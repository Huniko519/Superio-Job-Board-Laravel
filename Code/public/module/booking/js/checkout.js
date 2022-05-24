(function ($) {
    "use strict"
    new Vue({
        el:'#bravo-checkout-page',
        data:{
            onSubmit:false,
            message:{
                content:'',
                type:false
            }
        },
        methods:{
            doCheckout(){
                var me = this;

                if(this.onSubmit) return false;

                if(!this.validate()) return false;

                this.onSubmit = true;

                console.log($('.booking-form').find('input,textarea,select').serialize());

                $.ajax({
                    url:superio.routes.checkout,
                    data:$('.booking-form').find('input,textarea,select').serialize(),
                    method:"post",
                    success:function (res) {
                        if(!res.status && !res.url){
                            me.onSubmit = false;
                        }


                        if(res.elements){
                            for(var k in res.elements){
                                $(k).html(res.elements[k]);
                            }
                        }

                        if(res.message)
                        {
                            me.message.content = res.message;
                            me.message.type = res.status;
                        }

                        if(res.url){
                            window.location.href = res.url
                        }

                        if(res.errors && typeof res.errors == 'object')
                        {
                            var html = '';
                            for(var i in res.errors){
                                html += res.errors[i]+'<br>';
                            }
                            me.message.content = html;
                        }

                    },
                    error:function (e) {
                        me.onSubmit = false;
                        if(e.responseJSON){
							me.message.content = e.responseJSON.message ? e.responseJSON.message : 'Can not booking';
							me.message.type = false;
                        }else{
                            if(e.responseText){
								me.message.content = e.responseText;
								me.message.type = false;
                            }
                        }


                    }
                })
            },
            validate(){
                return true;
            }
        }
    })

    $(".form-checkout .gateways-table .card-header label").on('click',function () {
        $(".form-checkout .gateways-table .card").removeClass("active");
        $(this).closest(".card").addClass("active");
    });

})(jQuery)
