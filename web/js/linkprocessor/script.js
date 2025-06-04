class LinkProcessor
{
  constructor(){
    this.systemSettings = {
      'requests':{
        'check':'/resource/check'
      },
      'html':{
        'elements':{
            'qrfield':$('.js-linkprocessor-qrfield'),
        },
        'forms':{
          'checklink':{
            'input':$('.js-linkprocessor-form-input-link-check'),
            'buttonSend':$('.js-linkprocessor-form-button-check'),
            'buttonSendText':$('.js-linkprocessor-form-button-send-text-ok')
          }
        }
      },
      'classNames':{
        'loading':'css-linkprocessor-loading-bar',
        'hidden':'css-main-visibility-hidden',
        'inputError':'css-linkprocessor-input-error'
      },
      'statuses':{
        'forms':{
          'checklink':{
            'isCanCheck':true
          }
        }
      },
      'notifications':{
        'notAvailable':'Данный URL не доступен',
      }
    };
    this.init();
  }

  init(){
    this.eventWatcher();
  }

  eventWatcher(){
    this.systemSettings.html.forms.checklink.buttonSend.on('click',()=>{
      this.systemSettings.statuses.forms.checklink.isCanCheck && 
      this.check();
    });
  }

  loading(status = false){
    this.systemSettings.html.forms.checklink.buttonSend.removeClass(this.systemSettings.classNames.loading);
    this.systemSettings.html.forms.checklink.buttonSendText.removeClass(this.systemSettings.classNames.hidden); 

    status && this.systemSettings.html.forms.checklink.buttonSend.addClass(this.systemSettings.classNames.loading);
    status && this.systemSettings.html.forms.checklink.buttonSendText.addClass(this.systemSettings.classNames.hidden);    
  }

  inputView(status = false){
    this.systemSettings.html.forms.checklink.input.removeClass(this.systemSettings.classNames.inputError);

    status && this.systemSettings.html.forms.checklink.input.addClass(this.systemSettings.classNames.inputError);
  }

  check(){
    this.loading(true);
    const postData = {
      'link':this.systemSettings.html.forms.checklink.input.val()
    };
    this.inputView(false);

    if(this.isValidUrl(postData.link)){
      axios.post(this.systemSettings.requests.check, postData)
        .then((response) => this.successNewID(response))
        .catch((error) => this.handleError(error,5));
    }else{
      this.inputView(true);
    }
  }

  successNewID(response){
    console.log(response);
  }
  
  handleError(error){
    console.log(error);
  }

  isValidUrl(string){
    const pattern = /^(https?:\/\/)[\w\-]+(\.[\w\-]+)+[/#?]?.*$/i;
    return pattern.test(string);
  }

  buildQR(url){
    QRCode.toDataURL(url)
      .then(base64 => {
        this.renderQR(base64);
      })
      .catch(err => {
        console.error(err);
      });    
  }

  renderQR(base64String){
    this.systemSettings.html.elements.qrfield
      .css('background-image',`url('${base64String}')`);
  }
}

new LinkProcessor();
