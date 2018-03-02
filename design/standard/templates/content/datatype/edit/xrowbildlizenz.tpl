{def $base = ezini('eZJSCore', 'LocalScriptBasePath', 'ezjscore.ini')}

{ezscript_require( 'ezjsc::yui2' )}
{ezcss_require( concat( '/', $base.yui2, 'calendar/assets/calendar.css' ) )}

<script type="text/javascript">
	(function() {ldelim}
	    var loader = new YAHOO.util.YUILoader(YUI2_config);
	
	    loader.addModule({ldelim}
	        name: 'datepicker',
	        type: 'js',
	        fullpath: '{"javascript/ezdatepicker.js"|ezdesign( 'no' )}',
	        requires: ["calendar"],
	        after: ["calendar"],
	        skinnable: false
	    {rdelim});
	
	    loader.require(["datepicker"]);
	    loader.insert();
	{rdelim})();
</script>

{default attribute_base=ContentObjectAttribute}
	{def $id_base = concat( 'ezcoa-', $attribute.contentclassattribute_id, '_', $attribute.contentclass_attribute_identifier )}
	<div class="block">
	    <div class="selectlist" style="margin-top:16px;float:left;">
	        <div class="element">
				<select id="{$id_base}_selectlist" class="ezcc-{$attribute.object.content_class.identifier} ezcca-{$attribute.object.content_class.identifier}_{$attribute.contentclass_attribute_identifier}" name="{$attribute_base}_bildlizenz_selected_{$attribute.id}">
					<option value="0" {if $attribute.data_text|compare('0')}selected="selected"{/if}>{'Delete on'|i18n( 'extension/xrowbildlizenz/datatypes' )}</option>
					<option value="1" {if $attribute.data_text|compare('1')}selected="selected"{/if}>{'No expiration date'|i18n( 'extension/xrowbildlizenz/datatypes' )}</option>
				</select>
	        </div>
	    </div>
	    <div class="date">
	        <div class="element">
	            <label for="{$id_base}_year">{'Year'|i18n( 'design/admin/content/datatype' )}:</label>
	            <input id="{$id_base}_year" class="ezcc-{$attribute.object.content_class.identifier} ezcca-{$attribute.object.content_class.identifier}_{$attribute.contentclass_attribute_identifier}" type="text" name="{$attribute_base}_bildlizenz_year_{$attribute.id}" size="5" value="{section show=$attribute.content.is_valid}{$attribute.content.year}{/section}" />
	        </div>
	
	        <div class="element">
				<label for="{$id_base}_month">{'Month'|i18n( 'design/admin/content/datatype' )}:</label>
				<input id="{$id_base}_month"  class="ezcc-{$attribute.object.content_class.identifier} ezcca-{$attribute.object.content_class.identifier}_{$attribute.contentclass_attribute_identifier}" type="text" name="{$attribute_base}_bildlizenz_month_{$attribute.id}" size="3" value="{section show=$attribute.content.is_valid}{$attribute.content.month}{/section}" />
			</div>
	
			<div class="element">
			    <label for="{$id_base}_day">{'Day'|i18n( 'design/admin/content/datatype' )}:</label>
			    <input id="{$id_base}_day" class="ezcc-{$attribute.object.content_class.identifier} ezcca-{$attribute.object.content_class.identifier}_{$attribute.contentclass_attribute_identifier}" type="text" name="{$attribute_base}_bildlizenz_day_{$attribute.id}" size="3" value="{section show=$attribute.content.is_valid}{$attribute.content.day}{/section}" />
			</div>
			<div class="element">
				<img class="datepicker-icon" src={"calendar_icon.png"|ezimage} id="{$attribute_base}_bildlizenz_cal_{$attribute.id}" width="24" height="28" onclick="showDatePicker( '{$attribute_base}', '{$attribute.id}', 'bildlizenz' );" style="cursor: pointer;" />
				<div id="{$attribute_base}_bildlizenz_cal_container_{$attribute.id}" style="display: none; position: absolute;"></div>
				&nbsp;
				&nbsp;
				&nbsp;
				&nbsp;
		    </div>
		</div>
	
		<div class="time">
		    <div class="element">
		        <label for="{$id_base}_hour">{'Hour'|i18n( 'design/admin/content/datatype' )}:</label>
		        <input id="{$id_base}_hour" class="ezcc-{$attribute.object.content_class.identifier} ezcca-{$attribute.object.content_class.identifier}_{$attribute.contentclass_attribute_identifier}" type="text" name="{$attribute_base}_bildlizenz_hour_{$attribute.id}" size="3" value="{section show=$attribute.content.is_valid}{$attribute.content.hour}{/section}" />
		    </div>
	
			<div class="element">
			    <label for="{$id_base}_minute">{'Minute'|i18n( 'design/admin/content/datatype' )}:</label>
			    <input id="{$id_base}_minute" class="ezcc-{$attribute.object.content_class.identifier} ezcca-{$attribute.object.content_class.identifier}_{$attribute.contentclass_attribute_identifier}" type="text" name="{$attribute_base}_bildlizenz_minute_{$attribute.id}" size="3" value="{section show=$attribute.content.is_valid}{$attribute.content.minute}{/section}" />
	 		</div>
	    </div>
	
	    <div class="break"></div>
	</div>
{/default}
