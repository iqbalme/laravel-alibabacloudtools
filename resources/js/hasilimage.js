<style>html #content #qfy-product  nav.bitcommerce-pagination {text-align:left}html #content #qfy-product  .bitcommerce-pagination {position:relative;left:0px}html #content #qfy-product  .bitcommerce-pagination {position:relative;top:0px}html  #qfy-product ul.products li.product{padding-right:15px}html #qfy-product ul.products li.product .price{right:15px}html  #qfy-product ul.products li.product{padding-bottom:15px}html  #qfy-product .bitcommerce-pagination li a,html  #qfy-product .bitcommerce-pagination li span{display:inline-block;background-color: transparent;border: 1px solid #cccccc;color: #333;font-size: 16px;line-height: 16px;margin-right:3px;}html  #qfy-product .bitcommerce-pagination li a.current,html  #qfy-product .bitcommerce-pagination li span.current{background-color: #cccccc;border: 1px solid transparent;color:#fff}</style>
<style class="column_class qfy_style_class">@media only screen and (min-width: 992px){.qfy-column-6 > .column_inner {padding-left:10px;padding-right:10px;padding-top:10px;padding-bottom:10px;}.qfe_row .vc_span_class.qfy-column-6 {};}@media only screen and (max-width: 992px){.qfy-column-6 > .column_inner{margin:0 auto 0 !important;min-height:0 !important;padding-left:0;padding-right:0;padding-top:0;padding-bottom:0;}.display_entire .qfe_row .vc_span_class.qfy-column-6 {}.qfy-column-6 > .column_inner> .background-overlay,.qfy-column-6 > .column_inner> .background-media{width:100% !important;left:0 !important;right:auto !important;}}</style>
<script type='text/javascript'>
function refreshHalaman(){
     location.reload();
}

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('.image-upload-wrap').hide();
      $('.file-upload-image').attr('src', e.target.result);
      $('.file-upload-content').show();
      //$('.image-title').html(input.files[0].name);
    };
    reader.readAsDataURL(input.files[0]);
  } else {
    removeUpload();
  }
}

function removeUpload() {
  $('.file-upload-input').replaceWith($('.file-upload-input').clone());
  $('.file-upload-content').hide();
  $('.image-upload-wrap').show();
}
$('.image-upload-wrap').bind('dragover', function () {
		$('.image-upload-wrap').addClass('image-dropping');
	});
	$('.image-upload-wrap').bind('dragleave', function () {
		$('.image-upload-wrap').removeClass('image-dropping');
});

function DataURIToBlob(dataURI) {
  const splitDataURI = dataURI.split(',')
  const byteString = splitDataURI[0].indexOf('base64') >= 0 ? atob(splitDataURI[1]) : decodeURI(splitDataURI[1])
  const mimeString = splitDataURI[0].split(':')[1].split(';')[0]
  const ia = new Uint8Array(byteString.length)
  for (let i = 0; i < byteString.length; i++)
    ia[i] = byteString.charCodeAt(i)
  return new Blob([ia], { type: mimeString })
}
function cariPakeGambar(){
    var imgBase64 = $('.file-upload-image').attr('src');
	if(imgBase64 == '#'){
		alert('Anda harus memilih gambar terlebih dahulu!');
	} else {
		const file = DataURIToBlob(imgBase64)
		const formData = new FormData();
		formData.append('gambar', file, 'image.jpg');
		formData.append('nama', 'nama_file'); //other param
		//formData.append('path', 'temp/') //other param
		let loadingPic = '<div class="row qfe_row">' +
				'<div data-animaleinbegin="90%" data-animalename="qfyfadeInUp" data-duration="" data-delay="" class=" qfy-column-3 qfy-column-inner  vc_span12  text-default small-screen-default fullrow" data-dw="1/1" data-fixheight=""><div style=";position:relative;" class="column_inner "><div class=" background-overlay grid-overlay-" style="background-color: transparent;width:100%;"></div><div class="column_containter" style="z-index:3;position:relative;"><div id="vc_img_622327e45b4d8748" style="padding:0px;margin:0px;clear:both;position:relative;margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;border-radius:0px;background-position:0 0;background-repeat: no-repeat;" m-padding="0px 0px 0px 0px" p-padding="0 0 0 0" css_animation_delay="0" qfyuuid="qfy_imagetext_turxe" data-anitime="0.7" data-ani_iteration_count="1" class="qfy-element bitImageControlDiv "><style>@media only screen and (max-width: 768px) {.imagetext-622327e45b4f8879 .head{font-size: 16px !important;}.imagetext-622327e45b4f8879 .content{font-size: 16px !important;}#vc_img_622327e45b4d8748 .text_inner{padding:10px !important;}}</style><div class="bitImageParentDiv qfe_single_image imagetext qfe_content_element vc_align_center"><div class="qfe_wrapper"><div class="imagetext_inner" data-layout="2" data-mlayout="0" data-m-align1="0" data-m-align2="0"><div style="" class="image_inner" data-valign="0" data-align="1"><a class="bitImageAhover  "><img width="498" height="280" data-delay-image="1" src="https://i.postimg.cc/rsVYrzYk/loading.gif" class="front_image  attachment-full" alt="loading" title="" description="" data-title="loading" src-img="" style="display: inline;"></a></div><div style="padding:20px;text-color:#000000;" class="text_inner" data-valign="0" data-align="1">LOADING ....</div></div> </div></div></div> </div></div></div><style class="column_class qfy_style_class">@media only screen and (min-width: 992px){.qfy-column-3 > .column_inner {padding-left:0;padding-right:0;padding-top:0;padding-bottom:0;}.qfe_row .vc_span_class.qfy-column-3 {};}@media only screen and (max-width: 992px){.qfy-column-3 > .column_inner{margin:0 auto 0 !important;padding-left:0;padding-right:0;padding-top:;padding-bottom:;}.display_entire .qfe_row .vc_span_class.qfy-column-3 {}.qfy-column-3 > .column_inner> .background-overlay,.qfy-column-3 > .column_inner> .background-media{width:100% !important;left:0 !important;right:auto !important;}}</style></div>';
		$(".hasilPencarianImage").html(loadingPic); //show loading text
		$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url: "https://backend.alibabacloudtools.xyz/alibabacloudtools/index.php/upload",
			data: formData,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 30000,
			success: function (data) {
				let data1 = JSON.parse(data);
				$(".file-upload-content").hide();
				$(".image-upload-wrap").hide();
				$(".file-upload-btn").hide();
				$(".btn-cari-lagi").show();
				let beforeResult = '<div id="vc_header" m-padding="20px 0px 20px 0px" p-padding="20px 0 20px 0" css_animation_delay="0" qfyuuid="qfy_header_43nzu" data-anitime="0.7" data-ani_iteration_count="1" class="qfy-element minheigh1px qfe_text_column qfe_content_element " style="position: relative;;;background-repeat: no-repeat;;margin-top:0;margin-bottom:0;padding-top:20px;padding-bottom:20px;padding-right:0;padding-left:0;"><style>@media only screen and (max-width: 768px) {#vc_header .header_title{font-size:16px !important;}}@media only screen and (max-width: 768px) {#vc_header .header_subtitle{font-size:12px !important;}}</style><div class="qfe_wrapper"><h2 class="qfy_title center mobilecenter"><div class="qfy_title_inner" style="display:inline-block;position:relative;max-width:100%;"><div class="header_title" style="font-family:微軟正黑體;font-size:24px;font-weight:bold;font-style:normal;color:#000;" data-title_from="1">Hasil Pencarian dengan Gambar.</div></div><style></style><div class="button_wrapper" style="display:none;"><div class="button " style="display:inline-block;max-width:100%;text-align:center; font-size:14px; color:#333; padding:5px;">+ 查看更多</div></div><span style="clear:both;"></span></h2></div></div><div class="row qfe_row"><div class="bitcommerce defaultminheight mobile-columns-2 columns-4"><ul class="products">';
				let afterResult = '</ul></div></div><div class="clear"></div>';
				let resultProducts = "";
				if(data1.length > 0){
					for(let i=0;i<data1.length;i++){
						resultProducts += '<div class="vc-item">' +
									'<li class="product">' +
										'<div class="wd_product_wrapper">' +
											'<div border="0" width="100%" style="table-layout:fixed;" class="qfycustomtable">' +
												'<div class="qfycustomtr">' +
													'<div class="qfycustomtd lefttd" valign="top">' +				
														'<a class="product_a pitem" href="' + data1[i].product_link + '" target="">' +
															'<div class="front-image product_img "><img class=" ag_image" data-delay-image="1" src="' + data1[i].product_image + '" alt="' + data1[i].product_name + '" description="" title="" src-img="" style="display: block;"><i></i>' +
															'</div>' +
														'</a>' +
													'</div>' +
													'<div class="qfycustomtd righttd" valign="top">' +
														'<a href="' + data1[i].product_link + '" target=""><h3 class="product_title pitem">' + data1[i].product_name + '</h3></a>' +
													'</div>' +
												'</div>' +
											'</div>' +
										'</div>' +
									'</li>' +
								'</div>'
					}
					$(".hasilPencarianImage").html(beforeResult + resultProducts + afterResult);
				} else {
					let dataText = '<div id="vc_header" m-padding="20px 0px 20px 0px" p-padding="20px 0 20px 0" css_animation_delay="0" qfyuuid="qfy_header_43nzu" data-anitime="0.7" data-ani_iteration_count="1" class="qfy-element minheigh1px qfe_text_column qfe_content_element " style="position: relative;;;background-repeat: no-repeat;;margin-top:0;margin-bottom:0;padding-top:20px;padding-bottom:20px;padding-right:0;padding-left:0;"><style>@media only screen and (max-width: 768px) {#vc_header .header_title{font-size:16px !important;}}@media only screen and (max-width: 768px) {#vc_header .header_subtitle{font-size:12px !important;}}</style><div class="qfe_wrapper"><h2 class="qfy_title center mobilecenter"><div class="qfy_title_inner" style="display:inline-block;position:relative;max-width:100%;"><div class="header_title" style="font-family:微軟正黑體;font-size:24px;font-weight:bold;font-style:normal;color:#000;" data-title_from="1">Tidak ada hasil pencarian produk yang identik dengan gambar.</div></div><span style="clear:both;"></span></h2></div></div>';
					$(".hasilPencarianImage").html(dataText);
				}
			},
			error: function (e) {
				let errText = '<div id="vc_header" m-padding="20px 0px 20px 0px" p-padding="20px 0 20px 0" css_animation_delay="0" qfyuuid="qfy_header_43nzu" data-anitime="0.7" data-ani_iteration_count="1" class="qfy-element minheigh1px qfe_text_column qfe_content_element " style="position: relative;;;background-repeat: no-repeat;;margin-top:0;margin-bottom:0;padding-top:20px;padding-bottom:20px;padding-right:0;padding-left:0;"><style>@media only screen and (max-width: 768px) {#vc_header .header_title{font-size:16px !important;}}@media only screen and (max-width: 768px) {#vc_header .header_subtitle{font-size:12px !important;}}</style><div class="qfe_wrapper"><h2 class="qfy_title center mobilecenter"><div class="qfy_title_inner" style="display:inline-block;position:relative;max-width:100%;"><div class="header_title" style="font-family:微軟正黑體;font-size:24px;font-weight:bold;font-style:normal;color:#000;" data-title_from="1">' + e.responseText + '</div></div><span style="clear:both;"></span></h2></div></div>';
				$(".hasilPencarianImage").text(errText);
				$(".file-upload-content").hide();
				$(".image-upload-wrap").hide();
				$(".file-upload-btn").hide();
				$(".btn-cari-lagi").show();
			}
		});
	}
}
</script>