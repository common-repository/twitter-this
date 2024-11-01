jQuery.noConflict();

function mosform (id) {
	            var ide = "#form" + id; 
	            var myform = "#myForm" + id;
				var loader ="#loader" + id;
	           
				jQuery(ide).toggle('slow');
				
			    jQuery(loader).hide(); 
	           
			
				var options = { 
			        target:        ide, 
					beforeSubmit:  showRequest, 
			        success:       showResponse,  
					resetForm: true
			    }; 
	            
	           jQuery(myform).ajaxForm(options);
			
				function showRequest(formData, jqForm, options) { 
					
					for (var i=0; i < formData.length; i++) { 
        			if (!formData[i].value) { 
           			 alert('Por favor ingrese un valor para Usuario y Password'); 
           				 return false; 
        			} 
   				} 
					
					jQuery(loader).show(); } 
			    function showResponse(responseText, statusText)  {   }  
	            };
