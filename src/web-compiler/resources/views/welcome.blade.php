@extends('layout.Main',[
    "menu"=>'index'
    ])
@section('title', '')
@section('class', 'xSectionDetails')
@section('id', 'xSectionDetails')
@section('state', 'details')
@section('content')

<div class="xSectionInner">
                                        
	<div class="xRow xRow-2col_mid_mid n1 odd first" id="xSectionDetailsR1">
  <div class="xRowInner">
		
			<div class="xCell n1 first mid xModuleImage" id="xSectionDetailsR1C1">
  <div class="xCellInner">
				
					
					<div id="xSectionDetails_image_1618263402164" data-ngx-id="image_1618263402164" data-componenttype="image" style="" class="xComponent xImage n1 xMidColModule xTmpl-Item" data-registered="true">
  <div class="xComponentInner"><div class="xContainer xContainerImage xClassImage xTemplateItem hasItemMediacard xRenderExternal xItemCount1" data-ngx-contentsource="external">
  <div class="xContainerInner"><div class="xItem xContentImage xMediacard xClassImage xNetworkUgc xDisplayShow hasMainAsset">
  <div class="xItemInner">



<div class="xMediaContainer xRenderEmbed xMediaImage"><img src="https://a.wayin.com/images/7461/aad27b26-bbfb-4ee0-a25c-0af2f3943dbc/600x600.png" class="" alt="" height="600" width="600"></div>
















</div>
</div></div>
</div>

</div>
</div>
					
				 
			</div>
</div>
		
			<div class="xCell n2 last mid xModuleForm" id="xSectionDetailsR1C2">
  <div class="xCellInner">
				
					
					<div id="xSectionDetails_xModule" data-ngx-id="xModule" data-componenttype="form" style="" class="xComponent xForm n1 xMidColModule xTmpl-Left" data-registered="true">
  <div class="xComponentInner">








    
        
    






    <div class="xFormContainer"><form enctype="multipart/form-data" method="post" action="https://eu-api.wayin.com/api/interact/d/record" id="xCampaignForm" style="" role="form" data-ngx-method="ajax" class="xDefaultForm" novalidate="novalidate" data-flow="1">
  <div class="xFormPages" style="position: relative; height: 462px;">
<input type="hidden" name="apikey" value="d974e77d-3d7e-4bf2-a3de-096db68ebda8" id="apikey">
<input type="hidden" name="containerId" value="" id="containerId">
<input type="hidden" name="formId" value="306215" id="formId">
<input type="hidden" name="campaignId" value="235013" id="campaignId">
<input type="hidden" name="container_guid" value="aad27b26-bbfb-4ee0-a25c-0af2f3943dbc" id="container_guid">
<input type="hidden" name="mode" value="" id="mode">


	<input type="hidden" name="stageMode" value="true" id="stageMode">
	<input type="hidden" name="ptk" value="3d7dd676366cab285048d29824f31d64" id="stageToken">


<input type="hidden" name="promotionId" value="" id="promotionId">


<input type="hidden" name="ngxInvitedFriends" value="" id="ngxInvitedFriends">


	<input type="hidden" name="channelId" value="" id="channelId">

	<input type="hidden" name="medium" value="direct" id="medium">

	<input type="hidden" name="source" value="web" id="source">

	<input type="hidden" name="channel" value="website" id="channel">

	<input type="hidden" name="content" value="" id="content">

	<input type="hidden" name="activity" value="" id="activity">

	<input type="hidden" name="r" value="" id="r">









<input type="hidden" name="ngx_t_token" value="Myvsj2UIK3IbKVYYO+ZmqM0QTUF+e/w8l4keJwH5iJc=" id="ngx_t_token"><div class="xFormPage first odd n1  cycle-slide cycle-slide-active" style="position: absolute; top: 0px; left: 0px; z-index: 100; opacity: 1;">
	<fieldset>

		
			
			

	


			


		

		
			<div id="nameWrapper" data-ngx-id="name" data-ngx-control="name" data-ngx-control-required-msg="Por favor, ingresa tu nombre" data-parsley-error-container="#nameWrapper .xErrorLabel" data-ngx-control-error-msg="Por favor, ingresa tu nombre" class="xFieldItem xControlName xProfileName xFormatNameNoTitle xComposite xRequired"><div class="xLabelContainer">
  <label class="xFormLabel xControlLabel" for="name">Nombre:</label>
</div>
  <div class="xFieldContainer xFieldWidthMedium">

	<div class="xField xCompositeItem-FirstName">
		<input type="text" title="First name" name="name_Firstname" id="name_Firstname" aria-label="First name" data-parsley-trigger="focusout" data-ngx-subfield-error-key="FirstName" data-parsley-error-container="#nameWrapper .xErrorLabel" maxlength="64" data-parsley-required-message="Required." data-parsley-type-text-message="This value is invalid." data-parsley-name="name" data-ngx-validtype="name" placeholder="Nombre(s)" required="" data-ngx-populate="firstname" class="textField uniform-input text" data-ngx-api-bound="true">
		<label class="xSubLabel" for="name_Firstname">First name</label>
	</div>

	<div class="xField xCompositeItem-LastName">
		<input type="text" title="Last name" name="name_Lastname" id="name_Lastname" aria-label="Last name" data-parsley-trigger="focusout" data-ngx-subfield-error-key="LastName" data-parsley-error-container="#nameWrapper .xErrorLabel" maxlength="128" data-parsley-required-message="Required." data-parsley-type-text-message="This value is invalid." data-parsley-name="name" data-ngx-validtype="name" placeholder="Apellido(s)" required="" data-ngx-populate="lastname" class="textField uniform-input text" data-ngx-api-bound="true">
		<label class="xSubLabel" for="name_Lastname">Last name</label>
	</div>


    <div class="xHelpContainer"><div role="alert" class="xErrorLabel"></div></div>
  </div>
</div>
		
			<div id="PhoneWrapper" data-ngx-id="Phone" data-ngx-control-required-msg="Por favor, ingresa un número celular válido" data-parsley-error-container="#PhoneWrapper .xErrorLabel" data-ngx-control-error-msg="Por favor, ingresa un número celular válido" class="xFieldItem xControlPhone xProfilePhone xFormatPhoneInternational xRequired"><div class="xLabelContainer">
  <label class="xFormLabel xControlLabel" for="Phone">Número Celular:</label>
</div>
  <div class="xFieldContainer xFieldWidthMedium">
    <div class="xField"><input type="tel" title="Número Celular:" name="Phone" id="Phone" data-parsley-trigger="change focusout" data-parsley-validation-minlength="0" data-parsley-regexp="^[0-9\-()+.\s]{4}[a-zA-Z0-9\-()+.\s]{1,16}$" data-parsley-phone="int" data-parsley-regexp-message="Por favor, ingresa un número celular válido" data-parsley-error-container="#PhoneWrapper .xErrorLabel" data-parsley-required="true" data-parsley-required-message="Por favor, ingresa un número celular válido" data-parsley-type-phone-message="Por favor, ingresa un número celular válido" placeholder="(55) 5555 - 5555" required="" class="textField required parsley-validated uniform-input tel" data-ngx-api-bound="true"></div>
    <div class="xHelpContainer"><div role="alert" class="xErrorLabel"></div></div>
  </div>
</div>
		
			<div id="emailWrapper" data-ngx-id="email" data-ngx-control-required-msg="Por favor, ingresa un email válido" data-parsley-error-container="#emailWrapper .xErrorLabel" data-ngx-control-error-msg="Por favor, ingresa un email válido" class="xFieldItem xControlEmail xProfileEmail xRequired"><div class="xLabelContainer">
  <label class="xFormLabel xControlLabel" for="email">Correo electrónico:</label>
</div>
  <div class="xFieldContainer xFieldWidthMedium">
    <div class="xField"><input type="email" id="email" name="email" title="Correo electrónico:" data-ngx-populate="email" data-parsley-trigger="change focusout" data-parsley-validation-minlength="0" data-parsley-type="email" data-parsley-error-container="#emailWrapper .xFieldContainer > .xField:first-child + .xHelpContainer .xErrorLabel" data-parsley-required="true" data-parsley-required-message="Por favor, ingresa un email válido" data-parsley-type-email-message="Por favor, ingresa un email válido" placeholder="ejemplo@correo.com" required="" class="emailField textField required parsley-validated uniform-input email" data-ngx-api-bound="true"></div>
    <div class="xHelpContainer"><div role="alert" class="xErrorLabel"></div></div>
  </div>
</div>
		
			<div id="terms_and_conditionsWrapper" data-ngx-id="terms_and_conditions" data-ngx-control-required-msg="Para participar debes aceptar los términos y condiciones" data-parsley-error-container="#terms_and_conditionsWrapper .xErrorLabel" data-ngx-control-error-msg="Invalid error" class="xFieldItem xControlTerms_and_conditions xRequired">
  <div class="xFieldContainer"><div class="xField xFieldCheckboxChoice">
<div class="xCheckbox" id="xForm-tsandcs_check"><span><input type="checkbox" id="tsandcs_check" title="" class="checkField parsley-validated" name="terms_and_conditions" value="Acepto los [Link:Terms and Conditions]." tabindex="0" data-parsley-required="true" data-parsley-error-container="#terms_and_conditionsWrapper .xErrorLabel" data-parsley-trigger="change" data-parsley-mincheck="1" required="required" data-parsley-required-message="Para participar debes aceptar los términos y condiciones" data-ngx-api-bound="true"></span></div>
<label class="xFormLabel xFieldLabel xTermsAndConditionsLabel" for="tsandcs_check">Acepto los <a id="" href="#" data-ngx-action="route:rules" rel="" class="" target="_blank" role="button">Terms and Conditions</a>.</label>
</div>
    <div class="xHelpContainer"><div role="alert" class="xErrorLabel"></div></div>
  </div>
</div>
		
			<div id="brand_opt_inWrapper" data-ngx-id="brand_opt_in" data-ngx-control-error-msg="Invalid error" data-parsley-error-container="#brand_opt_inWrapper .xErrorLabel" class="xFieldItem xControlMarketing xProfileMarketingOptIn">
  <div style="" class="xFieldContainer"><div class="xField xFieldCheckboxChoice">
  <div class="xCheckbox" id="xForm-brand_opt_in_check"><span><input type="checkbox" id="brand_opt_in_check" title="Acepto la <a href=&quot;#&quot;>Política de Privacidad</a>" value="Acepto la <a href=&quot;#&quot;>Política de Privacidad</a>" class="checkField" autocomplete="off" name="brand_opt_in" data-group="brand_opt_in_check" data-ngx-api-bound="true"></span></div>
  <label class="xFormLabel xFieldLabel" for="brand_opt_in_check">Acepto la <a href="#">Política de Privacidad</a></label>
</div>
    <div class="xHelpContainer"><div role="alert" class="xErrorLabel"></div></div>
  </div>
</div>
		
			<div id="group_opt_inWrapper" data-ngx-id="group_opt_in" data-ngx-control-error-msg="Invalid error" data-parsley-error-container="#group_opt_inWrapper .xErrorLabel" class="xFieldItem xControlMarketing xProfileMarketingOptIn">
  <div style="" class="xFieldContainer"><div class="xField xFieldCheckboxChoice">
  <div class="xCheckbox" id="xForm-group_opt_in_check"><span><input type="checkbox" id="group_opt_in_check" title="Soy mayor de edad" value="Soy mayor de edad" class="checkField" autocomplete="off" name="group_opt_in" data-group="group_opt_in_check" data-ngx-api-bound="true"></span></div>
  <label class="xFormLabel xFieldLabel" for="group_opt_in_check">Soy mayor de edad</label>
</div>
    <div class="xHelpContainer"><div role="alert" class="xErrorLabel"></div></div>
  </div>
</div>
			<!-- EOF: Page Control Loop //-->

	</fieldset>
</div><div class="xFormPage last even n2  cycle-slide" style="position: absolute; top: 0px; left: 0px; z-index: 99; display: none;">
	<fieldset>

		

		
			<div id="ngxUserUploadWrapper" data-ngx-id="ngxUserUpload" data-ngx-control-required-msg="Required." data-parsley-error-container="#ngxUserUploadWrapper .xErrorLabel" data-ngx-control-error-msg="Invalid error" class="xFieldItem xControlUpload xRequired"><div class="xLabelContainer">
  <label class="xFormLabel xControlLabel" for="ngxUserUpload">Subir Ticket:</label>
</div>
  <div class="xFieldContainer xFieldWidthMedium">
    <div class="xField"><div class="xUploader" id="xForm-ngxUserUpload"><input type="file" id="ngxUserUpload" name="ngxUserUpload" title="Subir Ticket:" data-parsley-fileupload-message="There is a problem with the size or format of your photo." accept="image/*" data-ngx-type="image" data-ngx-maxsize="5242880" placeholder="Escoge una foto" data-parsley-trigger="" data-parsley-validation-minlength="0" data-parsley-error-container="#ngxUserUploadWrapper .xErrorLabel" data-parsley-required="true" data-parsley-required-message="Required." data-parsley-type-text-message="Invalid error" data-parsley-value="" data-parsley-fileupload="true" required="" class="uploadField xTypeImage required parsley-validated" data-ngx-api-bound="true"><span class="xFilename" style="user-select: none;">Escoge una foto</span><span class="xFileAction" style="user-select: none;">Choose File</span></div></div>
    <div class="xHelpContainer"><p class="xHelpLabel">Toma una foto de tu ticket completo. Máximo 5Mb</p><div role="alert" class="xErrorLabel"></div></div>
  </div>
</div>
			<!-- EOF: Page Control Loop //-->

	</fieldset>
</div></div>


	<div class="xItem xFieldItem buttons">




		<div class="xActionContainer xActionsForm">
			<div class="xPaginationContainer">
				<a class="xPagingButton xActionPaginate xActionPrevious xDisabled xHidden" href="#">
  <span>Previous</span>
</a>
				<a class="xPagingButton xActionPaginate xActionNext" href="#">
  <span>Next</span>
</a>
				
			</div>

			<div class="xActivateContainer xHidden">
			<div class="xErrorLabel">
				<span id="xSubmitButtonError" class="custom-error-message">There are some errors that need to be corrected</span>
			</div>
				<button type="submit" class="xButton xCTA xSubmit">
  <span>Enter</span>
</button>
			</div>

            <noscript>
                <div class="xMetaContainer">
                    <p class="xCopy">Entry requires Javascript to be enabled.</p>
                </div>
            </noscript>
		</div>

		
	</div>




</form></div>
    









</div>
</div>
					
				 
			</div>
</div>
		 
	</div>
</div>


                                    </div>


@endsection('content')