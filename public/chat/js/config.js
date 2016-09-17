var QBApp = {
  appId: 43119,
  authKey: 'HauGW8N542WjX8s',
  authSecret: 'z-dCdnBhWmCYLea'
};

var config = {
  chatProtocol: {
    active: 1
  },
  debug: {
    mode: 1,
    file: null
  },
  stickerpipe: {
    elId: 'stickers_btn',

    apiKey: '847b82c49db21ecec88c510e377b452c',

    enableEmojiTab: false,
    enableHistoryTab: true,
    enableStoreTab: true,

    userId: null,

    priceB: '0.99 $',
    priceC: '1.99 $'
  }
};

QB.init(QBApp.appId, QBApp.authKey, QBApp.authSecret, config);