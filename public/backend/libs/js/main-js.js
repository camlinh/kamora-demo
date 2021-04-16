
jQuery(document).ready(function ($) {
  'use strict';

  // ============================================================== 
  // Method list
  // ============================================================== 
  const clearErrorMessage = ($form) => {
    $form.find('.form-group').removeClass('has-errors');
    $form.find('.invalid-feedback').remove();
  }

  const renderMesssage = ($parent, text) => {
    return $parent.find(".invalid-feedback").length > 0
        ? $parent.find(".invalid-feedback").html(text)
        : $parent.append(`<div class="invalid-feedback">${text}</div>`);
  }

  const renderErrors = ($form, error) => {
    clearErrorMessage($form);

    if (error && error.message) {
        if (error.code == 422) {
            let errors = error.message;
            $.each(errors, function(key, msg) {
                let $el = $form.find(`[name^="${key}"]:not(:disabled)`);
                $el.val($.trim($el.val()));
                $el.closest(".form-group").addClass("has-errors");
                renderMesssage($el.closest(".form-group"), msg);
            });
        } else {
            toastr.error( error.message, "Error!");
        }
    }
  }

  const sendRequest = (url, method, data = {}, cb) => {
    return $.ajax({
      url: url,
      timeout: 100000,
      type: method,
      data: data,
      beforeSend: function (request) {
        return request.setRequestHeader(
          "X-CSRF-Token",
          $("meta[name='csrf-token']").attr("content")
        );
      },
      dataType: "json",
      success: function (response) {
        cb(response);
      }
    });
  }

  const sendRequestFormData = (url, method, data = {}, cb) => {
    return $.ajax({
      url: url,
      timeout: 100000,
      type: method,
      data: data,
      contentType: false,
      processData: false,
      beforeSend: function (request) {
        return request.setRequestHeader(
          "X-CSRF-Token",
          $("meta[name='csrf-token']").attr("content")
        );
      },
      success: function (response) {
        cb(response);
      }
    });
  }

  $.fn.formLoading = function (status) {
    if (this.length) {
      let $form = $(this);

      if (!$form.is('form')) {
        throw ('Invalid element!');
      }

      const loading = '<i class="fas fa-spinner fa-pulse icon"></i>';
      const $submitBtn = $form.find("button.btn-submit");

      switch (status) {
        case 'loading':
          $form.find("button").attr("disabled", true);
          $submitBtn.addClass("isLoading");
          $submitBtn.prepend(loading);
          break;

        case 'success':
          $form.find("button").attr("disabled", false);
          $submitBtn.removeClass("isLoading");
          $submitBtn.find('.icon').remove();
          break;

        default:
          break;
      }
    }

    return true;
  };

  // ============================================================== 
  // Notification list
  // ============================================================== 
  if ($(".notification-list").length) {

    $('.notification-list').slimScroll({
      height: '250px'
    });

  }

  // ============================================================== 
  // Menu Slim Scroll List
  // ============================================================== 


  if ($(".menu-list").length) {
    $('.menu-list').slimScroll({

    });
  }

  // ============================================================== 
  // Sidebar scrollnavigation 
  // ============================================================== 

  if ($(".sidebar-nav-fixed a").length) {
    $('.sidebar-nav-fixed a')
      // Remove links that don't actually link to anything

      .click(function (event) {
        // On-page links
        if (
          location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
          location.hostname == this.hostname
        ) {
          // Figure out element to scroll to
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
          // Does a scroll target exist?
          if (target.length) {
            // Only prevent default if animation is actually gonna happen
            event.preventDefault();
            $('html, body').animate({
              scrollTop: target.offset().top - 90
            }, 1000, function () {
              // Callback after animation
              // Must change focus!
              var $target = $(target);
              $target.focus();
              if ($target.is(":focus")) { // Checking if the target was focused
                return false;
              } else {
                $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                $target.focus(); // Set focus again
              };
            });
          }
        };
        $('.sidebar-nav-fixed a').each(function () {
          $(this).removeClass('active');
        })
        $(this).addClass('active');
      });

  }

  // ============================================================== 
  // tooltip
  // ============================================================== 
  if ($('[data-toggle="tooltip"]').length) {

    $('[data-toggle="tooltip"]').tooltip()

  }

  // ============================================================== 
  // popover
  // ============================================================== 
  if ($('[data-toggle="popover"]').length) {
    $('[data-toggle="popover"]').popover()

  }
  // ============================================================== 
  // Chat List Slim Scroll
  // ============================================================== 


  if ($('.chat-list').length) {
    $('.chat-list').slimScroll({
      color: 'false',
      width: '100%'
    });
  }
  // ============================================================== 
  // dropzone script
  // ============================================================== 

  //     if ($('.dz-clickable').length) {
  //            $(".dz-clickable").dropzone({ url: "/file/post" });
  // }

  $('.delete-confirm').on('click', function () {
    return confirm('Bạn có chắc chắn muốn xoá. Không thể phục hồi!');
  });

  $('.selectable').select2();

  $('.datepicker').each(function() {
    $(this).datepicker({
      format: $(this).data('format'),
      startDate: new Date()
    });
  });

  $('[data-toggle="tooltip"]').tooltip();

  /* Image Input*/
  function renderPreview($parent, value) {
    $parent.find('.preview').remove();
    let $preview = $('<div />', { class: "preview" });
    let img = new Image();
    img.src = value;
    $preview.html(img);
    $parent.append($preview);
  }

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      let $parent = $(input).closest('.form-group');
      $parent.find('.old-input').remove();
      reader.onload = function (e) {
        renderPreview($parent, e.target.result);
      }
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }

  $('.input-file').each(function () {
    let value = $(this).attr('value');
    let name = $(this).attr('name');
    let $parent = $(this).closest('.form-group');
    if (value) {
      renderPreview($parent, value);
      let $input = $('<input />', { class: "old-input", type: "hidden", name: `old_${name}`, value: value });
      $parent.append($input);
      $(this).removeAttr('value');
    }
  });

  $('.input-file').on('change', function () {
    readURL(this);
  });
  /* Image Input*/

  /* Form remote */
  $('input, select, textarea').on('change', function(e){
    let $parent = $(this).closest('.form-group');
    $parent.removeClass('has-errors');
    $parent.find('.invalid-feedback').remove();
  });

  $('.form-remote').on('submit', function (e) {
    e.preventDefault();

    let $form = $(this)
    let formData = new FormData(e.target);
    let formUrl = $form.attr('action');
    let formMethod = $form.attr('method');
    let inputMethod = $form.find('input[name="_method"]').length > 0
                      ? $form.find('input[name="_method"]').val().toUpperCase()
                      : formMethod;
    formData.set('_method', inputMethod);
    
    $form.formLoading('loading');
    clearErrorMessage($form);

    sendRequestFormData(formUrl, formMethod, formData, function (res) {
      if(res.status){
        let { data } = res;

        if(data.redirect_url){
          toastr.success(data.message, 'Success!');
          setTimeout(() =>  window.location.href = data.redirect_url, 800);
          return;
        }

        toastr.success(data, 'Success!');
        setTimeout(() =>  location.reload(), 800);
      }else{
        $form.formLoading('success');
        renderErrors($form, res.error);
      }
    });
  });

  $('.link-remote').on('click', function(e){
    e.preventDefault();
    const $el = $(this);
    const url = $el.attr('href');
    const method = $el.data('method');
    const loading = '<i class="fas fa-spinner fa-pulse mr-1 icon"></i>';

    $el.addClass('disabled');
    $el.prepend(loading);

    sendRequest(url, method, {}, function (res) {
      if(res.status){
        let { data } = res;

        if(data.redirect_url){
          toastr.success(data.message, 'Success!');
          setTimeout(() =>  window.location.href = data.redirect_url, 800);
          return;
        }

        toastr.success(data, 'Success!');
        setTimeout(() =>  location.reload(), 800);
      }else{
        $el.removeClass('disabled');
        $el.find('.icon').remove();
        toastr.error(res.error.message, 'Error!');
      }
    });
  })

}); // AND OF JQUERY
