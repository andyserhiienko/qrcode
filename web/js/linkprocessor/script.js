class LinkProcessor
{
  constructor(){
    this.systemSettings = {
      'requests':{
        'check':'/resource/check'
      },
      'html':{
        'elements':{
            'csrf':$('meta[name="csrf-token"]').attr('content'),
            'qrfield':$('.js-linkprocessor-qrfield'),
            'requestSatatus':$('.js-linkprocessor-request-satatus'),
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
      }
    };
    this.init();
  }

  init(){
    this.eventWatcher();
  }

  eventWatcher(){
    this.systemSettings.html.forms.checklink.buttonSend.on('click',()=>{
      this.isCanCheck() && this.check();
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
    const postData = {
      'url':this.systemSettings.html.forms.checklink.input.val()
    };
    this.setCanCheck(false);
    this.inputView(false);
    this.setStatus('');
    this.loading(true);

    if(this.isValidUrl(postData.url)){  
      axios.post(this.systemSettings.requests.check, postData, {
      headers: {'X-CSRF-Token': this.withCSRFToken()}})
        .then((response) => this.successNewID(response))
        .catch((error) => this.handleError(error));
    }else{
      this.setCanCheck(true);
      this.loading(false);
      this.inputView(true);
    }
  }

  setCanCheck(state = true){
    this.systemSettings.statuses.forms.checklink.isCanCheck = state;
  }

  isCanCheck(){
    return this.systemSettings.statuses.forms.checklink.isCanCheck;
  }

  setStatus(string){
    this.systemSettings.html.elements.requestSatatus.html(string);
  }

  successNewID(response){
    this.setCanCheck(true);
    this.loading(false);
    console.log(response);
  }
  
  handleError(error){
    this.setCanCheck(true);
    this.loading(false);
    this.inputView(true);

    error?.message && this.setStatus(error?.message);
    error.response?.data?.error && this.setStatus(error.response?.data?.error);
  }

  isValidUrl(string){
    const pattern = /^(https?:\/\/)[\w\-]+(\.[\w\-]+)+[/#?]?.*$/i;
    return pattern.test(string);
  }

  withCSRFToken(){
    return this.systemSettings.html.elements.csrf;//document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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
