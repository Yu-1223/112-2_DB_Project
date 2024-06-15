// 函數來取得URL中的GET參數
function getQueryParams() {
    var params = {};
    var queryString = window.location.search.substring(1);
    var queryArray = queryString.split('&');
    for (var i = 0; i < queryArray.length; i++) {
        var pair = queryArray[i].split('=');
        params[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
    }
    return params;
}

// 在頁面加載後顯示GET參數
window.onload = function() {
    var params = getQueryParams();
    if (params['msg']) {
        window.alert( params['msg'] + "!!" );
    }
};

//alert()
window.alert = function(msg, callback) {
    var div = document.createElement("div");
    div.innerHTML = "<style type=\"text/css\">"
            + ".nbaMask { position: fixed; z-index: 1000; top: 0; right: 0; left: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); }                                                                                                                                                                       "
            + ".nbaMaskTransparent { position: fixed; z-index: 1000; top: 0; right: 0; left: 0; bottom: 0; }                                                                                                                                                                                            "
            + ".nbaDialog { position: fixed; z-index: 5000; width: 80%; max-width: 200px; top: 50%; left: 50%; -webkit-transform: translate(-50%, -50%); transform: translate(-50%, -50%); background-color: white; text-align: center; border-radius: 8px; overflow: hidden; opacity: 1; color: #a66d2f; }"
            + ".nbaDialog .nbaDialogHd { padding: .2rem .27rem .08rem .27rem; }                                                                                                                                                                                                                         "
            + ".nbaDialog .nbaDialogHd .nbaDialogTitle { font-size: 25px; font-weight: 400; }                                                                                                                                                                                                           "
            + ".nbaDialog .nbaDialogBd { margin-top: 20px; margin-bottom: 20px; padding: 0 .27rem; font-size: 20px; line-height: 1.3; word-wrap: break-word; word-break: break-all; color: #a66d2f; }                                                                                                                                          "
            + ".nbaDialog .nbaDialogFt { position: relative; line-height: 40px; font-size: 17px; display: -webkit-box; display: -webkit-flex; display: flex; background-color: #cf883a; }                                                                                                                                          "
            + ".nbaDialog .nbaDialogFt:after { content: \" \"; position: absolute; left: 0; top: 0; right: 0; height: 1px; border-top: 1px solid #cf883a; color: #e6e6e6; -webkit-transform-origin: 0 0; transform-origin: 0 0; -webkit-transform: scaleY(0.5); transform: scaleY(0.5); }               "
            + ".nbaDialog .nbaDialogBtn { display: block; -webkit-box-flex: 1; -webkit-flex: 1; flex: 1; color: white; text-decoration: none; -webkit-tap-highlight-color: transparent; position: relative; margin-bottom: 0; }                                                                       "
            + ".nbaDialog .nbaDialogBtn:after { content: \" \"; position: absolute; left: 0; top: 0; width: 1px; bottom: 0; border-top: 1px solid #cf883a; color: #e6e6e6; -webkit-transform-origin: 0 0; transform-origin: 0 0; -webkit-transform: scaleX(0.5); transform: scaleX(0.5); }             "
            + ".nbaDialog a { text-decoration: none; -webkit-tap-highlight-color: transparent; }"
            + "</style>"
            + "<div id=\"dialogs\" style=\"display: none\">"
            + "<div class=\"nbaMask\"></div>"
            + "<div class=\"nbaDialog\">"
            + "    <div class=\"nbaDialogHd\">"
            + "        <strong class=\"nbaDialogTitle\"></strong>"
            + "    </div>"
            + "    <div class=\"nbaDialogBd\" id=\"dialog_msg\"></div>"
            + "    <div class=\"nbaDialogHd\">"
            + "        <strong class=\"nbaDialogTitle\"></strong>"
            + "    </div>"
            + "    <div class=\"nbaDialogFt\">"
            + "        <a href=\"javascript:;\" class=\"nbaDialogBtn nbaDialogBtnPrimary\" id=\"dialog_ok\">確定</a>"
            + "    </div></div></div>";
    document.body.appendChild(div);
 
    var dialogs = document.getElementById("dialogs");
    dialogs.style.display = 'block';
 
    var dialog_msg = document.getElementById("dialog_msg");
    dialog_msg.innerHTML = msg;
 
    var dialog_ok = document.getElementById("dialog_ok");
    dialog_ok.onclick = function() {
        dialogs.style.display = 'none';
        callback();
    };
};
