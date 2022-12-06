

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
<script>

        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        </script>
        <script>
            $(document).ready(function(){
                $(document).on('click','.add_product',function(e){
                    e.preventDefault();
                    let name=$('#name').val();
                    let price=$('#price').val();
                    //console.log(name+price);
                    $.ajax({
                        url:"{{ route('add.product') }}",
                        method:'post',
                        data:{name:name,price:price},
                        success:function(res){
                            if(res.status=='success'){
                                $('#addModal').modal('hide');
                                $('#addproductForm')[0].reset();
                                $('.table').load(location.href+' .table');
                                           //Toastr
                                           Command: toastr["success"]("Product Added!", "Success")

                                            toastr.options = {
                                            "closeButton": true,
                                            "debug": false,
                                            "newestOnTop": false,
                                            "progressBar": true,
                                            "positionClass": "toast-top-right",
                                            "preventDuplicates": false,
                                            "onclick": null,
                                            "showDuration": "300",
                                            "hideDuration": "1000",
                                            "timeOut": "5000",
                                            "extendedTimeOut": "1000",
                                            "showEasing": "swing",
                                            "hideEasing": "linear",
                                            "showMethod": "fadeIn",
                                            "hideMethod": "fadeOut"
                                            }
                                          //end toastr
                            }
                        },error:function(err){
                            let error=err.responseJSON;
                            $.each(error.errors,function(index,value){
                                $('.errMsgContainer').append('<span class="text-danger">'+value+'</span>'+'</br>');
                            });
                        }
                    });
                })
                // Show update product in update form
                $(document).on('click','.update_product_form',function(){
                    let id= $(this).data('id');
                    let name= $(this).data('name');
                    let price= $(this).data('price');

                    $('#up_id').val(id);
                    $('#up_name').val(name);
                    $('#up_price').val(price);
                });
                //update product data
                $(document).on('click','.update_product',function(e){
                    e.preventDefault();
                    let up_id=$('#up_id').val();
                    let up_name=$('#up_name').val();
                    let up_price=$('#up_price').val();

                    $.ajax({
                        url:"{{ route('update.product') }}",
                        method:'post',
                        data:{up_id:up_id,up_name:up_name,up_price:up_price},
                        success:function(res){
                            if(res.status=='success'){
                                $('#updateModal').modal('hide');
                                $('#updateProductForm')[0].reset();
                                $('.table').load(location.href+' .table');
                                //Toastr
                                Command: toastr["success"]("Product Updated!", "Success")
                                toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "newestOnTop": false,
                                "progressBar": true,
                                "positionClass": "toast-top-right",
                                "preventDuplicates": false,
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "5000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                                }
                                //end toastr
                            }
                        },error:function(err){
                            let error=err.responseJSON;
                            $.each(error.errors,function(index,value){
                                $('.errMsgContainer').append('<span class="text-danger">'+value+'</span>'+'</br>');
                            });
                        }
                    });
                })

                     //delete product data
                     $(document).on('click','.delete_product',function(e){
                    e.preventDefault();
                    let product_id= $(this).data('id');
                    if(confirm('Are you sure want to delete product??')){
                            $.ajax({
                            url:"{{ route('delete.product') }}",
                            method:'post',
                            data:{product_id:product_id},
                            success:function(res){
                                if(res.status=='success'){
                                    $('.table').load(location.href+' .table');

                                    //Toastr
                                    Command: toastr["success"]("Product Deleted!", "Success")

                                            toastr.options = {
                                            "closeButton": true,
                                            "debug": false,
                                            "newestOnTop": false,
                                            "progressBar": true,
                                            "positionClass": "toast-top-right",
                                            "preventDuplicates": false,
                                            "onclick": null,
                                            "showDuration": "300",
                                            "hideDuration": "1000",
                                            "timeOut": "5000",
                                            "extendedTimeOut": "1000",
                                            "showEasing": "swing",
                                            "hideEasing": "linear",
                                            "showMethod": "fadeIn",
                                            "hideMethod": "fadeOut"
                                            }


                                    //end toastr
                                }
                            }
                        });

                    }
                })
                // pagination
                $(document).on('click','.pagination a',function(e){
                    e.preventDefault();
                    let page=$(this).attr('href').split('page=')[1]
                    product(page)
                  })
                    function product(page){
                        $.ajax({
                            url:"/pagination/paginate-data?page="+page,
                            success:function(res){
                               $('.table-data').html(res);
                            }
                        })

                    }
                    //Search Product
                    $(document).on('keyup',function(e){
                        e.preventDefault();
                        let search_string=$('#search').val();

                        $.ajax({
                            url:"{{route('search.product')}}",
                            method:'GET',
                            data:{search_string:search_string},
                            success:function(res){
                                $('.table-data').html(res);
                                if(res.status=='nothing_found'){
                                    $('.table-data').html('<span class="text-danger">'+'Nothing Found'+'</span>');
                                }
                            }
                        });
                    })
            });
        </script>
