<script type="text/template" id="customize-happyforms-select-template">
	<?php include( happyforms_get_core_folder() . '/templates/customize-form-part-header.php' ); ?>
	<p class="label-field-group">
		<label for="<%= instance.id %>_title"><?php _e( 'Label', 'happyforms' ); ?></label>
		<div class="label-group">
			<input type="text" id="<%= instance.id %>_title" class="widefat title" value="<%= instance.label %>" data-bind="label" />
			<select id="<%= instance.id %>_label_placement" name="label_placement" data-bind="label_placement" class="widefat">
				<option value="show"<%= (instance.label_placement == 'show') ? ' selected' : '' %>><?php _e( 'Show', 'happyforms' ); ?></option>
				<% if ( 'left' == instance.label_placement ) { %>
					<option value="left" selected><?php _e( 'Left', 'happyforms' ); ?></option>
				<% } %>
				<% if ( 'below' == instance.label_placement ) { %>
					<option value="below" selected><?php _e( 'Below', 'happyforms' ); ?></option>
				<% } %>
				<option value="hidden"<%= (instance.label_placement == 'hidden') ? ' selected' : '' %>><?php _e( 'Hide', 'happyforms' ); ?></option>
			</select>
		</div>
	</p>
	<p class="happyforms-placeholder-option" style="display: <%= ( 'as_placeholder' !== instance.label_placement ) ? 'block' : 'none' %>">
		<label for="<%= instance.id %>_placeholder"><?php _e( 'Placeholder', 'happyforms' ); ?></label>
		<input type="text" id="<%= instance.id %>_placeholder" class="widefat title" value="<%= instance.placeholder %>" data-bind="placeholder" />
	</p>
	<p>
		<label for="<%= instance.id %>_description"><?php _e( 'Hint', 'happyforms' ); ?></label>
		<textarea id="<%= instance.id %>_description" data-bind="description"><%= instance.description %></textarea>
	</p>

	<?php do_action( 'happyforms_part_customize_select_before_options' ); ?>

	<div class="options">
		<ul class="option-list"></ul>
		<h3><?php _e( 'Choices', 'happyforms' ); ?></h3>
		<p class="no-options description"><?php _e( 'No choices added yet.', 'happyforms' ); ?></p>
	</div>
	<div class="options-import">
		<h3><?php _e( 'Choices', 'happyforms' ); ?></h3>
		<textarea class="option-import-area" cols="30" rows="10" placeholder="<?php _e( 'Type or paste your choices here, adding each on a new line.' ); ?>"></textarea>
	</div>
	<p class="links mode-manual">
		<a href="#" class="button add-option"><?php _e( 'Add choice', 'happyforms' ); ?></a>
		<span class="centered">
			<a href="#" class="import-options"><?php _e( 'Or, bulk add choices', 'happyforms' ); ?></a>
		</span>
	</p>
	<p class="links mode-import">
		<a href="#" class="button import-option"><?php _e( 'Add choices', 'happyforms' ); ?></a>
		<span class="centered">
			<a href="#" class="add-options"><?php _e( 'Cancel', 'happyforms' ); ?></a>
		</span>
	</p>
	<p>
		<label>
			<input type="checkbox" class="checkbox" value="1" <% if ( instance.required ) { %>checked="checked"<% } %> data-bind="required" /> <?php _e( 'Require an answer', 'happyforms' ); ?>
		</label>
	</p>

	<?php do_action( 'happyforms_part_customize_select_after_options' ); ?>

	<?php do_action( 'happyforms_part_customize_select_before_advanced_options' ); ?>

	<?php happyforms_customize_part_width_control(); ?>

	<?php do_action( 'happyforms_part_customize_select_after_advanced_options' ); ?>

	<p>
		<label for="<%= instance.id %>_css_class"><?php _e( 'CSS classes', 'happyforms' ); ?></label>
		<input type="text" id="<%= instance.id %>_css_class" class="widefat title" value="<%= instance.css_class %>" data-bind="css_class" />
	</p>

	<div class="happyforms-part-logic-wrap">
		<div class="happyforms-logic-view">
			<?php happyforms_customize_part_logic(); ?>
		</div>
	</div>

	<?php happyforms_customize_part_footer(); ?>
</script>
<script type="text/template" id="customize-happyforms-select-item-template">
	<li data-option-id="<%= id %>">
		<div class="happyforms-part-item-body">
			<div class="happyforms-part-item-handle"></div>
			<label>
				<?php _e( 'Label', 'happyforms' ); ?>:
				<input type="text" class="widefat" name="label" value="<%= label %>" data-option-attribute="label">
			</label>
			<div class="happyforms-part-item-advanced">
				<label>
					<input type="checkbox" name="is_default" value="1" class="default-option-switch"<% if (is_default == 1) { %> checked="checked"<% } %>> <?php _e( 'Make this choice default', 'happyforms' ); ?>
				</label>
			</div>
			<div class="option-actions">
				<a href="#" class="delete-option"><?php _e( 'Delete', 'happyforms' ); ?></a> |
				<a href="#" class="advanced-option"><?php _e( 'More', 'happyforms' ); ?></a>
			</div>
		</div>
	</li>
</script>
