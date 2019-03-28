document.addEventListener('DOMContentLoaded',function(){
	document.querySelector('.wbl-space').style = 'display:none !important' // бесит эта хрень
	document.querySelectorAll('.drop-area')[0].dragTable('preview')
	document.querySelectorAll('.drop-area')[1].dragTable('detail')
	Custom.Styles.ShowHideEditor()
	Custom.Styles.SelectTypeEvent();
	for (var i = document.querySelectorAll('.date-input').length - 1; i >= 0; i--) {
		Custom.Styles.DateCustomise(document.querySelectorAll('.date-input')[i])
	}
	Custom.Styles.SelectSeasonDiscount()
	Custom.Styles.TextLineStyles()
	document.querySelector('form.promotion').addEventListener('submit',function(e){
		e.preventDefault()
		Custom.Styles.showErrors();
		$.ajax({
			url: document.querySelector('input[name=AJAX]').value,
			data: Custom.Promotion.data,
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST', // For jQuery < 1.9
		    success: function(data){
		        console.log(data);
		    }
		})
	})
	console.log('test');
})
console.log('testet')
