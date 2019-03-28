var Custom = (function(win,doc,$){
	var Styles = {
		TextLineStyles: function(){
			$('#styles-for-textline').selectize({
				maxItems: 3,
				create: true,
				placeholder: 'font-family: Arial; font-size:14px; color: black;',
				onChange: function(value){
					console.log(value);
			    	if(value.length == 0)
			    		Promotion.data.delete("STYLES_FOR_TEXTLINE")
			    	else
			    		Promotion.addFile(value,"STYLES_FOR_TEXTLINE")
			    }
			})
		},
		SelectSeasonDiscount: function(){
			$('#season-discount').selectize({
			    maxItems: null,
			    // valueField: 'id',
			    // labelField: 'title',
			    // searchField: 'title',
			    // options: [
			    //     {id: 10, title: '10%', url: 'http://en.wikipedia.org/wiki/Spectrometers'},
			    //     {id: 20, title: '20%', url: 'http://en.wikipedia.org/wiki/Star_chart'},
			    //     {id: 30, title: '30%', url: 'http://en.wikipedia.org/wiki/Electrical_tape'}
			    // ],
			    create: true,
			    onChange: function(value){
			    	if(value.length == 0)
			    		Promotion.data.delete("SEASON_DISCOUNTS")
			    	else
			    		Promotion.addFile(value,"SEASON_DISCOUNTS")
			    }
			});
		},
		ShowHideEditor: function(){
			var clickHappend = false
			doc.querySelector('#add-text').addEventListener('click',function(e){
				var text = e.target.innerText
				var div = doc.querySelector('#detail-text')
				if(!clickHappend){
					$('#detail-text').addHTMLEditor('detail_text',400)
					e.target.innerText = "Скрыть"
					clickHappend = true
				}else{
					if(text == 'Скрыть'){
						e.target.innerText = 'Показать'
						div.style.display = 'none' 
					}else{
						e.target.innerText = 'Скрыть'
						div.style.display = 'block' 
					}
				}
			})
		},
		SelectTypeEvent: function(){
			var  input = doc.querySelector('#discount-amount')
			var stopInput = function(event){
				sum = String(event.target.value)
				sum += event.key
				console.log(event.key)
				if(sum > 100 || !/\d/.test(event.key))
					event.preventDefault()

			}
			doc.querySelector('#type').addEventListener('change',function(e){
				switch(e.target.value){
					case 'Perc':
						input.value= ""
						input.classList.add('percent')
						input.addEventListener('keypress',stopInput)
						break;
					case 'CurEach':
						input.value= ""
						if(input.classList.contains('percent'))
							input.classList.toggle('percent')
						input.removeEventListener('keypress',stopInput)
				}
			})
		},
		DateCustomise: function(element){
			_this = this
			var date = element.querySelector('.date-date').getAttribute('id')
			var time = element.querySelector('.date-time').getAttribute('id')
			var name = element.querySelector('.date-date').getAttribute('name')
			var cleave = new Cleave("#"+time,{time: true,
				timePattern: ['h', 'm', 's'],
				onValueChanged: function(e){
					element.removeError()
					if(cleave1.getFormattedValue()=="")
						cleave1.setRawValue(Promotion.today())
					if(e.target.rawValue.length == 6){
						var data = Promotion.setDate(cleave1.getFormattedValue(),e.target.value)
						Promotion.addFile(data,name)
						var data=Promotion.dateCheck(function(e){
							e.data.delete(name)
						})
						Styles.showDateError(data,element)
					}
				}
			})
			var cleave1 = new Cleave("#"+date,{date:true,
				datePattern: ['d','m','Y'],
				onValueChanged: function(e){
					element.removeError()
					if(cleave.getFormattedValue()=="")
						cleave.setRawValue('000000')
					if(e.target.rawValue.length == 8){
						var data = Promotion.setDate(e.target.value,cleave.getFormattedValue())
						Promotion.addFile(data,name)
						var data=Promotion.dateCheck(function(e){
							e.data.delete(name)
						})
						Styles.showDateError(data,element)
					}
				}
			})

		},
		showError: function(element){
			element.classList.add('error-show');
		},
		removeError: function(element){
			if(element.classList.contains('error-show'))
				element.classList.toggle('error-show')
		},
		showDateError: function(date,curElement){
			if(date == 'date1')
				doc.querySelectorAll('.date-input')[0].showError()
			if(date == 'date2')
				doc.querySelectorAll('.date-input')[1].showError()
			if(date == 'fatalError')
				curElement.showError()
		},
		//autoComplete: function()
	// {
	// 	var data = document.querySelector('input[name=props]').value
	// 	var data = JSON.parse(data.replace(/\'/g,'"'))
	// 	console.log(data);
	// },/
		showErrors: function(){
			var errors = Promotion.getAllInfo()
			if(errors.length>0){
				for (var i = errors.length - 1; i >= 0; i--) {
					document.querySelector("#"+errors[i]).showError()
				}
			}
			if(Promotion.dateCheck()){
				var date = document.querySelectorAll('.date-input')
				for (var i = date.length - 1; i >= 0; i--) {
					date[i].showError()
				}
			}
			if(Promotion.dateCheck() || errors.length>0)
				throw new Error('0')
		}
	}
	var Promotion = {
		data : new FormData(),
		addFile: function(file,name){
			if(this.data.has(name))
				this.data.delete(name)
			this.data.append(name,file)	
		},
		debugfiles : function(){
			for(var pair of this.data.entries()) {
			   console.log(pair); 
			}
		},
		setDate: function(date,time){
			date = date.replace(/\//g,'.')
			return date+" "+time;
		},
		today: function(){
			var today = new Date()
			var day = (today.getDate()<10)? "0"+String(today.getDate()):String(today.getDate())
			var month = (today.getMonth()<10)? "0"+String(today.getMonth()+1):String(today.getMonth()+1)
			var	str = day+month+String(today.getFullYear())
			return str
		},
		checkYear: function(date,revers){
			var today = new Date()
			if(parseInt(date.split('/')[2])<today.getFullYear())
				return false
			return true
		},
		dateCheck: function(func){
			var date_from = this.dateJSFormat('DATE_FROM')
			var date_to = this.dateJSFormat('DATE_TO')
			var today = new Date()
			if(!date_from && !date_to)
				return true
			if(date_from && !date_to){
				// if(date_from < today){
				// 	this.data.delete('DATE_FROM')
				// 	return 'date1'
				// }
				return "lack_of_to"
			}else if(!date_from && date_to){
				// if(date_to < today){
				// 	this.data.delete('DATE_TO')
				// 	return 'date2'
				// }
				return "lack_of_from"
			}else{
				// if(date_from < today){
				// 	this.data.delete('DATE_FROM')
				// 	return 'date1'
				// }
				// if(date_to < today){
				// 	this.data.delete('DATE_TO')
				// 	return 'date2'
				// }
				if(date_from >= date_to){
					if(typeof func != 'undefined')
						func(this)
					return 'fatalError'
				}
			}
			return false
		},
		dateJSFormat: function(key){
			if(!this.data.has(key))
				return false
			if(!/^\d{2}\.\d{2}\.\d{4}\s{1}\d{2}\:\d{2}\:\d{2}$/.test(this.data.get(key)))
			 	return false
			var date = this.data.get(key)
			date = date.split('.')
			var formated= ""
			formated += date[2].split(" ")[0]+"-"+date[1]+"-"+date[0]+" "+date[2].split(" ")[1]
			return new Date(formated)
		},
		getAllInfo: function(){
			var errors = [];
			var name = doc.querySelector('#name');
			var type = doc.querySelector('#type');
			var discount_amount = doc.querySelector('#discount-amount');
			var coupon = doc.querySelector('#discount-coupon');
			var doc_code = doc.querySelector('#code-of-document');
			var text_line = doc.querySelector('#text-line');
			var text_line_href = document.querySelector('#href-text-line');
			this.data.delete(name.name);
			this.data.delete(discount_amount.name);
			this.data.delete(coupon.name);
			this.data.delete(doc_code.name);
			this.data.delete(text_line.name);
			if(name.value == "")
				errors.push(name.id);
			else
				this.addFile(name.value,name.name);
			if(type.value == "Выберите тип скидки")
				errors.push(type.id);
			else{
				this.addFile(discount_amount.value,discount_amount.name);
				this.addFile(type.value,'DISCOUNT_TYPE');
			}
			if(coupon.value != "")
				this.addFile(coupon.value,coupon.name);
			if(text_line_href.value != "")
				this.addFile(text_line_href.value,text_line_href.name);
			if(doc_code.value == "")
				errors.push(doc_code.id);
			else
				this.addFile(doc_code.value,doc_code.name);
			if(text_line.value != "")
				this.addFile(text_line.value,text_line.name);
			var checkbox = doc.querySelectorAll('input[type=checkbox]');
			for (var i = checkbox.length - 1; i >= 0; i--) {
				this.addFile(checkbox[i].checked,checkbox[i].name)
			}
			this.addFile(doc.querySelector('input[name=IBLOCK]').value,"IBLOCK");
			this.addFile(doc.querySelector('input[name=PROP_ID]').value,"PROP_ID");
			this.addFile('y','ajax');
			return errors
		}
	}
	var Drag = function(){
		this.dropArea = false,
		this.dataForSend = new FormData(),
		this.type = false,
		this.init = function(element,type){
			_this = this
			this.dropArea = element
			this.type = type
			var arr = ['dragenter','dragleave','dragover','drop']
			this.dropArea.addEventListener('dragenter',this.dragenter.bind(this))
			this.dropArea.addEventListener('dragleave',this.dragleave.bind(this))
			this.dropArea.addEventListener('dragover',this.dragenter.bind(this))
			this.dropArea.addEventListener('drop',this.drop.bind(this))
			this.dropArea.querySelector('.close').addEventListener('click',this.deletePhoto.bind(this))
			this.dropArea.querySelector('svg').addEventListener('click',this.clickAddHandler.bind(this))
			this.dropArea.querySelector('svg').addEventListener('mouseover',this.dragenter.bind(this))
			this.dropArea.querySelector('svg').addEventListener('mouseleave',this.dragleave.bind(this))
			for (var i = arr.length - 1; i >= 0; i--) {
				this.dropArea.addEventListener(arr[i],this.preventDefault,false)
			}
		}
	}
	Drag.prototype.preventDefault = function(e){
		e.preventDefault()
		e.stopPropagation()
	}
	Drag.prototype.dragenter =  function(event){
		this.dropArea.querySelector('svg path').style.fill = "greenyellow";
		this.dropArea.style.borderColor = "greenyellow";
	}
	Drag.prototype.dragleave = function(event){
		this.dropArea.querySelector('svg path').style.fill = "black";
		this.dropArea.style.borderColor = "black"; 
	}
	Drag.prototype.fileRead = function(file){
		var reader = new FileReader()
		reader.readAsDataURL(file)
		_this = this
		reader.onloadend = function(){
			_this.dropArea.querySelector('a').classList.add('active')
			var img = new Image();
            img.onload = function(){
            	var width = img.width
				var height = img.height
				var canvas = document.createElement("canvas")
				var ctx = canvas.getContext("2d")
				ctx.drawImage(img,0,0)
				var width = img.width
				var height = img.height
				var MAX_WIDTH = 292
				var MAX_HEIGHT = 292
				if (width > height) {
		            if (width > MAX_WIDTH) {
		                height *= MAX_WIDTH / width
		                width = MAX_WIDTH
		            }
		        }else {
		            if (height > MAX_HEIGHT) {
		                width *= MAX_HEIGHT / height
		                height = MAX_HEIGHT
		            }
		        }
		        canvas.width = width
		        canvas.height = height
		        var ctx = canvas.getContext("2d")
		        ctx.drawImage(img, 0, 0, width, height)
		        dataurl = canvas.toDataURL(file.type);
			  	_this.dropArea.querySelector('img').src = dataurl
			  	_this.dropArea.querySelector('img').style.margin = ''+(MAX_HEIGHT-canvas.height)/2+'px auto'
            }
         	img.src = reader.result;
	    }    
	}
	Drag.prototype.drop = function(event){
		var dt = event.dataTransfer
		var files = dt.files
		for (var i = files.length - 1; i >= 0; i--) {
			Promotion.addFile(files[i],this.type)
			this.fileRead(files[i])
		}
		this.dropArea.querySelector('svg').style.opacity = "0";
		this.dragleave() 
	}
	Drag.prototype.deletePhoto = function(event){
		event.preventDefault();
		if(Promotion.data.has(this.type)){
			Promotion.data.delete(this.type)
			this.dropArea.querySelector('img').src = ''
			this.dropArea.querySelector('.close').classList.toggle('active')
			this.dropArea.querySelector('svg').style.opacity = "1";
			this.dropArea.querySelector('svg path').style.fill = "black";
			this.dropArea.style.borderColor = "black"; 
		}
	}
	Drag.prototype.clickAddHandler = function(){
		_this = this
		var input =  doc.createElement('input')
		input.type = 'file'
		event = input.addEventListener('change',function(e){
			file = e.path[0].files[0]
			_this.fileRead(file)
			Promotion.addFile(file,_this.type)
			_this.dropArea.querySelector('svg').style.opacity = "0"
			input.removeEventListener('click',event)
		})
		input.click()

	}
	HTMLElement.prototype.dragTable = function(name){
		drag = new Drag()
		drag.init(this,name)
	}
	HTMLElement.prototype.remove = function(){
		if(this.parentNode){
			this.parentNode.removeChild(this)
		}
	}
	HTMLElement.prototype.showError = function(){
		Styles.showError(this)
	}
	HTMLElement.prototype.removeError = function(){
		Styles.removeError(this)
	}
	jQuery.fn.extend({
		addHTMLEditor: function(name,height){
			var params = {
				height: height,
				charCounterCount: false,
				fileUpload: false,
				toolbarButtons:  ['bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript',
				 '|', 'fontFamily', 'fontSize','inlineClass', 'inlineStyle', 'paragraphStyle', 'lineHeight', '|'
				 , 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 'insertLink',
				   'insertVideo', 'embedly', 'insertFile', 'insertTable', '|', 'emoticons', 'fontAwesome',
				   'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'print', 'getPDF', 'spellChecker',
				    'help', 'html', '|', 'undo', 'redo']
			}
			this.froalaEditor(params);
			this.css('display','block')
			this.on('froalaEditor.html.get', function (e, editor, html) {
			Promotion.addFile(html,name)	
			});
		}
	})
	return {Styles,Promotion}
})(window,document,jQuery,URL)
