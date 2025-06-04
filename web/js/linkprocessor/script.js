class LinkProcessor
{
  constructor(){
    this.systemSettings = {
      'requests':{
        'check':'/link/check'
      },
      'html':{
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
        'hidden':'css-main-visibility-hidden'
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

  check(){

    this.loading(true);
    const postData = {
      'link':this.systemSettings.html.forms.checklink.input.val()
    };

    axios.post(this.systemSettings.requests.check, postData)
      .then((response) => this.successNewID(response))
      .catch((error) => this.handleError(error,5));
  }
}

new LinkProcessor();
