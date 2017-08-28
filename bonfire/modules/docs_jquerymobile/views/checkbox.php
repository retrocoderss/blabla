		<h1>Checkbox</h1>

		<p>Checkbox inputs are used to provide a list of options where more than one can be selected. Checkbox buttons are enhanced by the checkboxradio widget.</p>

		<h2>Basic markup</h2>

		<p>To create a single checkbox, add an <code>input</code> with a <code>type="checkbox"</code> attribute and a corresponding <code>label</code>. If the <code>input</code> isn't wrapped in its corresponding <code>label</code>, be sure to set the <code>for</code> attribute of the <code>label</code> to match the <code>id</code> of the <code>input</code> so they are semantically associated.</p>

		<div data-demo-html="true">
            <form>
               	<label>
                	<input type="checkbox" name="checkbox-0 ">Check me
                </label>
        	</form>
		</div><!--/demo-html -->

		<h2>Mini size</h2>

		<p>For a more compact version that is useful in toolbars and tight spaces, add the <code>data-mini="true"</code> attribute to the element to create a mini version. </p>

		<div data-demo-html="true">
            <form>
				<input type="checkbox" name="checkbox-mini-0" id="checkbox-mini-0" data-mini="true">
				<label for="checkbox-mini-0">I agree</label>
        	</form>
		</div><!--/demo-html -->

		<h2>Vertical group</h2>

		<p>Typically, there are multiple checkboxes listed under a question title. To visually integrate multiple checkboxes into a grouped button set, the framework will automatically remove all margins between buttons and round only the top and bottom corners of the set if there is a <code> data-role="controlgroup"</code> attribute on the <code>fieldset</code>.</p>

		<div data-demo-html="true">
            <form>
               	<fieldset data-role="controlgroup">
					<legend>Vertical:</legend>
					<input type="checkbox" name="checkbox-v-2a" id="checkbox-v-2a">
					<label for="checkbox-v-2a">One</label>
					<input type="checkbox" name="checkbox-v-2b" id="checkbox-v-2b">
					<label for="checkbox-v-2b">Two</label>
					<input type="checkbox" name="checkbox-v-2c" id="checkbox-v-2c">
					<label for="checkbox-v-2c">Three</label>
				</fieldset>
        	</form>
		</div><!--/demo-html -->

		<h2>Horizontal group</h2>

		<p>Checkboxes can also be used for grouped button sets where more than one button can be selected at once, such as the bold, italic and underline button group seen in word processors. To make a horizontal button set, add the <code> data-type="horizontal"</code> to the <code>fieldset</code>.</p>

		<div data-demo-html="true">
            <form>
				<fieldset data-role="controlgroup" data-type="horizontal">
					<legend>Horizontal:</legend>
					<input type="checkbox" name="checkbox-h-2a" id="checkbox-h-2a">
					<label for="checkbox-h-2a">One</label>
					<input type="checkbox" name="checkbox-h-2b" id="checkbox-h-2b">
					<label for="checkbox-h-2b">Two</label>
					<input type="checkbox" name="checkbox-h-2c" id="checkbox-h-2c">
					<label for="checkbox-h-2c">Three</label>
				</fieldset>
        	</form>
		</div><!--/demo-html -->

		<h2>Icon position</h2>

		<p>To swap the position of the check icon from the default position on the left, add the <code>data-iconpos="right"</code> attribute to the fieldset to create a mini version. </p>

		<div data-demo-html="true">
			<form>
				<fieldset data-role="controlgroup" data-iconpos="right">
					<legend>Icon right:</legend>
					<input type="checkbox" name="checkbox-h-6a" id="checkbox-h-6a">
					<label for="checkbox-h-6a">One</label>
					<input type="checkbox" name="checkbox-h-6b" id="checkbox-h-6b">
					<label for="checkbox-h-6b">Two</label>
					<input type="checkbox" name="checkbox-h-6c" id="checkbox-h-6c">
					<label for="checkbox-h-6c">Three</label>
				</fieldset>
			</form>
		</div><!--/demo-html -->

		<h2>Theme</h2>

		<p>To set the theme, add the <code>data-theme</code> attribute on the <code>fieldset</code> to the individual checkbox inputs.</p>

		<div data-demo-html="true">
            <form>
               	<fieldset data-role="controlgroup">
					<legend>Swatch B:</legend>
					<input type="checkbox" name="checkbox-t-2a" id="checkbox-t-2a" data-theme="b">
					<label for="checkbox-t-2a">One</label>
					<input type="checkbox" name="checkbox-t-2b" id="checkbox-t-2b" data-theme="b">
					<label for="checkbox-t-2b">Two</label>
					<input type="checkbox" name="checkbox-t-2c" id="checkbox-t-2c" data-theme="b">
					<label for="checkbox-t-2c">Three</label>
				</fieldset>
        	</form>
		</div><!--/demo-html -->

		<h2>Disabled</h2>

		<div data-demo-html="true">
            <form>
					<input disabled type="checkbox" name="checkbox-t-2a" id="checkbox-t-2a" data-theme="a">
					<label for="checkbox-t-2a">One</label>
        	</form>
		</div><!--/demo-html -->

		<h2>Enhanced</h2>

        <div data-demo-html="true">
			<div class="ui-checkbox">
				<label for="checkbox-enhanced" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-checkbox-off">I agree</label>
				<input type="checkbox" name="checkbox-enhanced" id="checkbox-enhanced" data-enhanced="true">
			</div>
		</div><!--/demo-html -->