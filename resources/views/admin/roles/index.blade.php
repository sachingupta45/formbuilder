<x-admin-layout>
    <section class="section">
        <form id="formbuilderdata" >

        </form>
        <button class="btn btn-secondary" id="submitform">Submit data</button>
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
            console.log(formRenderInstance.userData);
            jQuery('#submitform').on('click',function () {
                console.log("hlo sachin gupta");
                console.log(formRenderInstance.userData);
            })
            
            
        });
    </script>
    @endpush
</x-admin-layout>
