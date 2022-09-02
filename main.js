$(document).ready(function () {
  // loader
  // $(".loader-wrapper").fadeOut("slow");
  $(".menu__icon").click(() => {
  $(".body_taskbar").toggleClass('transidebar')
  $(".main__content").toggleClass("tran__main-content")
  
  });
  
});
function Validation(formSelector, options) {

  if (!options) {
      var options = {};
  };

  function getParent(element, selector) {
      while (element.parentElement) {
          if (element.parentElement.matches(selector)) {
              return element.parentElement;
          };
          element =  element.parentElement;
      };
  };

  var issetForm = document.querySelector(formSelector);
  var submitButton = issetForm.getElementsByTagName('Button');
  var formRules = {};
  var validationRules = {
      required: function (value) {
          return value ? undefined : 'This field can not be empty';
      },
      email: function (value) {
          var regex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
          return regex.test(value) ? undefined : 'Email is not valid';
      },
      min: function (min) {
          return function (value) {
              return value.length >= min ? undefined : `This field must be at least ${min} characters`;
          }
      },
  };

  if (issetForm) {
    
      var inputs = issetForm.querySelectorAll('[name][rules]');
      for (var input of inputs) {
          var inputRules = input.getAttribute('rules').split('&');
          for (var rule of inputRules) {
              var ruleInfo;
              var rulseHasValue = rule.includes('=');
              if (rulseHasValue) {
                  ruleInfo = rule.split('=');
                  rule = ruleInfo[0];
              };
              var ruleFunction = validationRules[rule];
              if (rulseHasValue) {
                  ruleFunction = ruleFunction(ruleInfo[1]);
              };
              if (Array.isArray(formRules[input.name])) {
                  formRules[input.name].push(ruleFunction);
              } else {
                  formRules[input.name] = [ruleFunction];
              };
          };
          input.onblur = handleValidate;
          input.oninput = handleClearError;
          issetForm.querySelector('.btn').classList.add('disabled');
      };

      inputs[inputs.length -1].addEventListener('input', (e)=>{
          issetForm.querySelector('.btn').classList.remove('disabled');
      });

      function handleValidate(e) {
          var rules = formRules[e.target.name];
          var inputValue = e.target.value;
          var errorMessage;
          var parent;
          var error;
          for (rule of rules) {
              errorMessage = rule(inputValue);
              if (errorMessage) break;
          };
          if (errorMessage) {
              var parent = getParent(event.target,'.form-validation');
              if (parent) {
                  var errorBox = parent.querySelector('.error-message');
                  if (errorBox) {
                      errorBox.innerText = errorMessage;
                  };
                  parent.classList.add('invalid');
              };
          };
          return !errorMessage;
      };

      function handleClearError(e) {
          var input = e.target;
          var parent = getParent(input,'.form-validation');
          var errorBox = parent.querySelector('.error-message');
          parent.classList.remove('invalid');
          errorBox.innerText = '';
      };

      issetForm.addEventListener('submit', (e)=>{
          e.preventDefault();
          var isValid = true;
          var inputs = issetForm.querySelectorAll('[name][rules]');
          for (var input of inputs) {
              if (!handleValidate({target: input})) {
                  isValid = false;
              };
          };
          if (isValid) {
              if (typeof options.onSubmit == 'function') {
                  var btnDisable = issetForm.querySelector('.btn');

                  // Return form values
                  var formInputs = issetForm.querySelectorAll('[name]');
                  var formValues = Array.from(formInputs).reduce(function (values, input) {
                      return (values[input.name] = input.value) && values;
                  }, {});
               
                  options.onSubmit(formValues);

              } else {
                  issetForm.submit();
              };
          };
      });

  };
};

function preloader(){
    $('.loader-wrapper').hide();
}
function validation_submitform(url){
    if($('form')){
        Validation("form", {
    
            onSubmit: function(data) {
                $.ajax({                                                                               
                    async: true,                                                                       
                    type: "post",                                                                      
                    data: data,                                                     
                    url: url,                                                               
                    success: function (response) { 
                        if(response.status) {
                            alertify.success(response.msg);
                            if(response.redirect) {
                                window.location.href = response.redirect;
                            }
                        }else{
                            alertify.error(response.msg);
                            if(response.expired){
                                var x = setInterval(function() {
                                    var now = new Date().getTime();
                                   
                                    var distance = response.expired *1000 - now;
                                    console.log(distance)
                                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                    $('p').html('Your account has been unactivated in ' + seconds + 's')
                                    $('p').addClass('invalid')
                                    $(":submit").attr("disabled", true);
                                    $(":submit").removeClass("form-submit");


                                    if (distance < 0) {
                                        clearInterval(x);
                                        $('p').html('');
                                        $(":submit").removeAttr("disabled");
                                        $(":submit").addClass("form-submit");
                                        $('p').removeClass('invalid')

                                      }
                                },1000)
                            }

                        }                                                        
                    },                                                                                 
                });  
            },
        });
    }
}

function submitformAction(url,method){
    form.submit(e => {
        e.preventDefault();
        var data =form.serialize()
        console.log(data)
        $.ajax({
            type: method,
            url: url,
            data: data,
            success: function (data) {
                if(data.status) {
                    alertify.success(data.msg);
                    if(data.redirect) {
                        window.location.href = data.redirect;
                    }
                }else{
                    alertify.error(data.msg);
                }
            },
            error: function (data) {
                console.log(data.responseText);
            },
        })
    })
}
function submitFormdata(formdata,url) {
  
    $.ajax({                                                                               
            url,
            method: 'POST',
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            data: formdata,                                                            
            success: function (response) {   
            if(response.status) {
                alertify.success(response.msg);
                if(response.redirect) {
                    window.location.href = response.redirect;
                }
            }else{
                alertify.error(response.msg);

            }                                                        
        },                                                                                 
    });  
}

