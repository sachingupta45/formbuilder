<x-admin-layout>
    <section class="section">
        <div class="card">
            <form  id="formdform">
            <div class="card">
                <div class="card-header">
                  <h4>Toggle Switches</h4>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <div class="control-label">Toggle switches</div>
                    <div class="custom-switches-stacked mt-2">
                      <label class="custom-switch">
                        <input type="radio" name="option" value="1" class="custom-switch-input" checked="">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Option 1</span>
                      </label>
                      <label class="custom-switch">
                        <input type="radio" name="option" value="2" class="custom-switch-input">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Option 2</span>
                      </label>
                      <label class="custom-switch">
                        <input type="radio" name="option" value="3" class="custom-switch-input">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Option 3</span>
                      </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="control-label">Toggle switch single</div>
                    <label class="custom-switch mt-2">
                      <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                      <span class="custom-switch-indicator"></span>
                      <span class="custom-switch-description">I agree with terms and conditions</span>
                    </label>
                  </div>
                </div>
              </div>
                <div class="card-body" id="formbuilderdata"></div>

                <button class="btn btn-info" type="submit" id="submitform">Submit data</button>
            </form>
        </div>
    </section>
    @push('particular-scripts')
    <script>
        jQuery(function ($) {
            
            var formfield = @json($form->fields ?? []); 
            if(!formfield)
            {
                return ;
            }
            var formRenderOptions = {
                formData: formfield,
            }
            var formRenderInstance = $('#formbuilderdata').formRender(formRenderOptions);
            console.log(typeof(formRenderInstance.userData),formRenderInstance.userData);

            var form = $("#formdform");
            var validator = form.validate({
                // Any global validation options can go here
            });
            formRenderInstance.userData.forEach(function(field) {
              var fieldSelector = field.name ? "[name='" + field.name + "']" : "";
              console.log(field.name,field.type);
              if (fieldSelector) 
              {
                if(field.type == 'number')
                {  $(fieldSelector).rules("add", {
                        required: true,
                        min:5,
                        messages: {
                            required: field.label + " is required  sachin gupta.",
                            min: field.label + " minimum 5 number must be there."
                        }
                    });
                }else{
                  $(fieldSelector).rules("add", {
                          required: true,
                          messages: {
                              required: field.label + " is required  sachin gupta."
                          }
                      });
                }
              }
            });

            jQuery('#submitform').validate({
                    submitHandler: function(form) {
                        form.submit(); 
                    }
                });
        });
    </script>
    @endpush
</x-admin-layout>
