const Keyboardmode3name2 = {
    elements: {
        main: null,
        keysContainer: null,
        keys: []
    },

    eventHandlers: {
        oninput: null,
        onclose: null
    },

    properties: {
        value: "",
        capsLock: false
    },

    init() {
        // Create main elements
        this.elements.main = document.createElement("div");
        this.elements.keysContainer = document.createElement("div");

        // Setup main elements
        this.elements.main.classList.add("keyboard_mode3name2", "keyboard--hidden_mode3name2");
        this.elements.keysContainer.classList.add("keyboard__keysname2");
        this.elements.keysContainer.appendChild(this._createKeys(lang,"th"));

        this.elements.keys = this.elements.keysContainer.querySelectorAll(".keyboard__key");

        // Add to DOM
        this.elements.main.appendChild(this.elements.keysContainer);
        document.body.appendChild(this.elements.main);

        // Automatically use keyboard for elements with .use-keyboard-input
        document.querySelectorAll(".use-keyboard-input-mode3name2").forEach(element => {
            element.addEventListener("click", () => {
                var length = element.value.length;
                var x = length - (length - element.selectionStart);
                var str = element.value;
                var res = str.substring(0, x);
                var res2 = str.substring(x, length);
                document.getElementById("pos_char").value=x;                
                this.open(element.value, currentValue => {
                    element.value=currentValue;
                });
            });
        });
        
        document.addEventListener( "click", someListener );
        function someListener(event){
        	var element =event.target;
        	//console.log(element)
        	if(element.classList.contains("use-keyboard-input-mode3name2") || element.classList.contains("material-icons") || element.classList.contains("keyboard__key") || element.classList.contains("keyboard__keysname2")){
	        	
        	}else{
                    var keyboard=document.querySelector(".keyboard_mode3name2");
	            keyboard.classList.add("keyboard--hidden_mode3name2");
        	}
           
        }
        
    },
    _createKeys(lang,hoa) {
        const fragment = document.createDocumentFragment();
        const keyLayout = [
            "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "backspace",
            "ㅂ", "ㅈ", "ㄷ", "ㄱ", "ㅅ", "ㅛ", "ㅕ", "ㅑ", "ㅐ", "ㅔ",
            "caps", "ㅁ", "ㄴ", "ㅇ", "ㄹ", "ㅎ", "ㅗ", "ㅓ", "ㅏ", "ㅣ", "enter",
            "done", "ㅋ", "ㅌ", "ㅊ", "ㅍ", "ㅠ", "ㅜ", "ㅡ", ",", ".", "?",
            "EN","KR","VN","space"
        ];
        const keyLayoutHOA = [
            "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "backspace",
            "ㅃ", "ㅉ", "ㄸ", "ㄲ", "ㅆ", "", "", "", "ㅒ", "ㅖ",
            "caps", "", "", "", "", "", "", "", "", "", "enter",
            "done", "", "", "", "", "", "", "", ",", ".", "?",
            "EN","KR","VN","space"
        ];
        const keyLayoutEN = [
            "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "backspace",
            "q", "w", "e", "r", "t", "y", "u", "i", "o", "p",
            "caps", "a", "s", "d", "f", "g", "h", "j", "k", "l", "enter",
            "done", "z", "x", "c", "v", "b", "n", "m", ",", ".", "?",
            "EN","KR","VN","space"
        ];
        const keyLayoutENHOA = [
            "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "backspace",
            "Q", "W", "E", "R", "T", "Y", "U", "I", "O", "P",
            "caps", "A", "S", "D", "F", "G", "H", "J", "K", "L", "enter",
            "done", "Z", "X", "C", "V", "B", "N", "M", ",", ".", "?",
            "EN","KR","VN","space"
        ];
        const keyLayoutVN = [
            "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "backspace",
            "q", "w", "e", "r", "t", "y", "u", "i", "o", "p",
            "caps", "a", "s", "d", "f", "g", "h", "j", "k", "l", "enter",
            "done", "z", "x", "c", "v", "b", "n", "m", ",", ".", "?",
            "EN","KR","VN","space"     
        ];
        const keyLayoutVNHOA = [
            "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "backspace",
            "Q", "W", "E", "R", "T", "Y", "U", "I", "O", "P",
            "caps", "A", "S", "D", "F", "G", "H", "J", "K", "L", "enter",
            "done", "Z", "X", "C", "V", "B", "N", "M", ",", ".", "?",
            "EN","KR","VN","space"     
        ];
        // Creates HTML for an icon
        const createIconHTML = (icon_name) => {
            return `<i class="material-icons">${icon_name}</i>`;
        };
        if(lang=="en"){
            if(hoa=="HOA"){
                var mang=keyLayoutENHOA;
            }else{
                var mang=keyLayoutEN;
            }
            //console.log(mang);
            mang.forEach(key => {
            const keyElement = document.createElement("button");
            const insertLineBreak = ["backspace", "p","P", "enter", "?"].indexOf(key) !== -1;

            // Add attributes/classes
            keyElement.setAttribute("type", "button");
            keyElement.classList.add("keyboard__key");

            switch (key) {
                case "backspace":
                    keyElement.classList.add("keyboard__key--wide");
                    keyElement.innerHTML = createIconHTML("backspace");
                    keyElement.addEventListener("click", () => {
                        //this.properties.value = this.properties.value.substring(0, this.properties.value.length - 1);
                        var x=document.getElementById("pos_char").value;
                        if(x>0){
                            var length = this.properties.value.length;                
                            var str = this.properties.value;
                            var res = str.substring(0, x);
                            var res2 = str.substring(x, length);
                            res=res.substring(0, res.length - 1)
                            this.properties.value=res+res2;
                            document.getElementById("pos_char").value=parseInt(x)-1;
                        }
                        this._triggerEvent("oninput");
                    });
                    break;
                case "caps":
                    keyElement.classList.add("keyboard__key--wide", "keyboard__key--activatable");
                    if(hoa=="HOA"){
                        keyElement.classList.add("keyboard__key--active");
                    }
                    keyElement.innerHTML = createIconHTML("keyboard_capslock");
                    keyElement.addEventListener("click", () => {
                        if(hoa=="HOA"){
                            hoa="th";
                        }else{
                            hoa="HOA";
                        }
                        this._toggleCapsLock(lang,hoa);                                                
                    });
                    break;                
                case "enter":
                    keyElement.classList.add("keyboard__key--wide");
                    keyElement.innerHTML = createIconHTML("keyboard_return");

                    keyElement.addEventListener("click", () => {
                        var settingname1 = $('#name2').val();
                        document.getElementById("settingname2").value = settingname1;
                        $('.name2').html(settingname1);
                        //$('#usernamepoint1').modal('hide');
                        
                        this.eventHandlers.oninput = oninput;
                        this.eventHandlers.onclose = onclose;
                        this.elements.main.classList.add("keyboard--hidden_mode3name2");
                        this.properties.value += "\n";
                        this._triggerEvent("oninput");
                    });

                    break;
                case "space":
                    keyElement.classList.add("keyboard__key--extra-wide");
                    keyElement.innerHTML = createIconHTML("space_bar");

                    keyElement.addEventListener("click", () => {
                        //this.properties.value += " ";
                        var x=document.getElementById("pos_char").value;
                        var length = this.properties.value.length;                
                        var str = this.properties.value;
                        var res = str.substring(0, x);
                        var res2 = str.substring(x, length);
                        this.properties.value=res+" "+res2;
                        document.getElementById("pos_char").value=parseInt(x)+1;
                        this._triggerEvent("oninput");
                    });

                    break;

                case "done":
                    keyElement.classList.add("keyboard__key--wide", "keyboard__key--dark");
                    keyElement.innerHTML = createIconHTML("check_circle");

                    keyElement.addEventListener("click", () => {
                        this.close();
                        this._triggerEvent("onclose");
                    });
                    break;
                case "EN":
                    keyElement.innerHTML = key;
                    keyElement.classList.add("keyboard__key--wide","keyboard__key--activatable","keyboard__key--active_lang","activatableen"); 
                    keyElement.addEventListener("click", () => {
                        this._changeLanguage("en",hoa);
                    });
                    break;
                case "KR":
                    keyElement.innerHTML = key;
                    keyElement.classList.add("keyboard__key--wide","keyboard__key--activatable","activatablekr");
                    keyElement.addEventListener("click", () => {
                        this._changeLanguage("kr",hoa);
                    });
                    break;
                case "VN":
                    keyElement.innerHTML = key;
                    keyElement.classList.add("keyboard__key--wide","keyboard__key--activatable","activatablevn");
                    keyElement.addEventListener("click", () => {
                        this._changeLanguage("vn",hoa);
                    });
                    break;
                case "language":
                    keyElement.innerHTML = createIconHTML("language");
                    keyElement.addEventListener("click", () => {
                        this._changeLanguage("kr",hoa);
                    });
                break;
                default:
                    keyElement.textContent = key;
                    keyElement.addEventListener("click", () => {
                        //this.properties.value += key;
                        var x=document.getElementById("pos_char").value;
                        var length = this.properties.value.length;                
                        var str = this.properties.value;
                        var res = str.substring(0, x);
                        var res2 = str.substring(x, length);
                        this.properties.value=res+key+res2;
                        document.getElementById("pos_char").value=parseInt(x)+1;
                        this._triggerEvent("oninput");
                    });

                    break;
            }

            fragment.appendChild(keyElement);

            if (insertLineBreak) {
                fragment.appendChild(document.createElement("br"));
            }
        });
        }
        if(lang=="vn"){
            if(hoa=="HOA"){
                var mang=keyLayoutVNHOA;
            }else{
                var mang=keyLayoutVN;
            }
            //console.log(mang);
            mang.forEach(key => {
            const keyElement = document.createElement("button");
            const insertLineBreak = ["backspace", "p", "P", "enter", "?"].indexOf(key) !== -1;

            // Add attributes/classes
            keyElement.setAttribute("type", "button");
            keyElement.classList.add("keyboard__key");

            switch (key) {
                case "backspace":
                    keyElement.classList.add("keyboard__key--wide");
                    keyElement.innerHTML = createIconHTML("backspace");
                    keyElement.addEventListener("click", () => {
                        //this.properties.value = this.properties.value.substring(0, this.properties.value.length - 1);
                        var x=document.getElementById("pos_char").value;
                        var length = this.properties.value.length;                
                        var str = this.properties.value;
                        var res = str.substring(0, x);
                        var res2 = str.substring(x, length); 
                        res=res.substring(0, res.length - 1);
                        var stringlength=vietTyping(res,"");                         
                        this.properties.value=stringlength+res2;                        
                        document.getElementById("pos_char").value=parseInt(stringlength.length);
                        this._triggerEvent("oninput");
                    });
                    break;
                case "caps":
                    keyElement.classList.add("keyboard__key--wide", "keyboard__key--activatable");
                    if(hoa=="HOA"){
                        keyElement.classList.add("keyboard__key--active");
                    }
                    keyElement.innerHTML = createIconHTML("keyboard_capslock");
                    keyElement.addEventListener("click", () => {
                        if(hoa=="HOA"){
                            hoa="th";
                        }else{
                            hoa="HOA";
                        }
                        this._toggleCapsLock(lang,hoa);                                                
                    });
                    break;                
                case "enter":
                    keyElement.classList.add("keyboard__key--wide");
                    keyElement.innerHTML = createIconHTML("keyboard_return");

                    keyElement.addEventListener("click", () => {
                        var settingname1 = $('#name2').val();
                        document.getElementById("settingname2").value = settingname1;
                        $('.name2').html(settingname1);
                        //$('#usernamepoint1').modal('hide');
                        
                        this.eventHandlers.oninput = oninput;
                        this.eventHandlers.onclose = onclose;
                        this.elements.main.classList.add("keyboard--hidden_mode3name2");
                        this.properties.value += "\n";
                        this._triggerEvent("oninput");
                    });

                    break;
                case "space":
                    keyElement.classList.add("keyboard__key--extra-wide");
                    keyElement.innerHTML = createIconHTML("space_bar");

                    keyElement.addEventListener("click", () => {
                        //this.properties.value += " ";
                        var x=document.getElementById("pos_char").value;
                        var length = this.properties.value.length;                
                        var str = this.properties.value;
                        var res = str.substring(0, x);
                        var res2 = str.substring(x, length);
                        this.properties.value=res+" "+res2;
                        document.getElementById("pos_char").value=parseInt(x)+1;
                        this._triggerEvent("oninput");
                    });

                    break;

                case "done":
                    keyElement.classList.add("keyboard__key--wide", "keyboard__key--dark");
                    keyElement.innerHTML = createIconHTML("check_circle");

                    keyElement.addEventListener("click", () => {
                        this.close();
                        this._triggerEvent("onclose");
                    });
                    break;
                case "EN":
                    keyElement.innerHTML = key;
                    keyElement.classList.add("keyboard__key--wide","keyboard__key--activatable","activatableen"); 
                    keyElement.addEventListener("click", () => {
                        this._changeLanguage("en",hoa);
                    });
                    break;
                case "KR":
                    keyElement.innerHTML = key;
                    keyElement.classList.add("keyboard__key--wide","keyboard__key--activatable","activatablekr");
                    keyElement.addEventListener("click", () => {
                        this._changeLanguage("kr",hoa);
                    });
                    break;
                case "VN":
                    keyElement.innerHTML = key;
                    keyElement.classList.add("keyboard__key--wide","keyboard__key--activatable","keyboard__key--active_lang","activatablevn");
                    keyElement.addEventListener("click", () => {
                        this._changeLanguage("vn",hoa);
                    });
                    break;
                case "language":
                    keyElement.innerHTML = createIconHTML("language");
                    keyElement.addEventListener("click", () => {
                        this._changeLanguage("kr",hoa);
                    });
                break;
                default:
                    keyElement.textContent = key;
                    keyElement.addEventListener("click", () => {
                        //this.properties.value=vietTyping(this.properties.value,key)
                        var x=document.getElementById("pos_char").value;
                        var length = this.properties.value.length;                
                        var str = this.properties.value;
                        var res = str.substring(0, x);
                        var res2 = str.substring(x, length); 
                        var stringlength=vietTyping(res,key);                        
                        this.properties.value=stringlength+res2;                        
                        document.getElementById("pos_char").value=parseInt(stringlength.length);
                        this._triggerEvent("oninput");
                    });

                    break;
            }

            fragment.appendChild(keyElement);

            if (insertLineBreak) {
                fragment.appendChild(document.createElement("br"));
            }
        });
        }
        if(lang=="kr"){
            if(hoa=="HOA"){
                var mang=keyLayoutHOA;
            }else{
                var mang=keyLayout;
            }
            mang.forEach(key => {
            const keyElement = document.createElement("button");
            const insertLineBreak = ["backspace", "ㅔ","ㅖ", "enter", "?"].indexOf(key) !== -1;

            // Add attributes/classes
            keyElement.setAttribute("type", "button");
            keyElement.classList.add("keyboard__key");

            switch (key) {
                case "backspace":
                    keyElement.classList.add("keyboard__key--wide");
                    keyElement.innerHTML = createIconHTML("backspace");
                    keyElement.addEventListener("click", () => {
                        //this.properties.value = this.properties.value.substring(0, this.properties.value.length - 1);
                        var x=document.getElementById("pos_char").value;
                        if(x>0){
                            var length = this.properties.value.length;                
                            var str = this.properties.value;
                            var res = str.substring(0, x);
                            var res2 = str.substring(x, length); 
                            res=res.substring(0, res.length - 1);
                            var stringlength=Hangul.a(Hangul.d(res));                        
                            this.properties.value=stringlength+res2;                              
                            document.getElementById("pos_char").value=parseInt(stringlength.length);
                        }
                        this._triggerEvent("oninput");
                    });
                    break;
                case "caps":
                    keyElement.classList.add("keyboard__key--wide", "keyboard__key--activatable");
                    if(hoa=="HOA"){
                        keyElement.classList.add("keyboard__key--active");
                    }
                    keyElement.innerHTML = createIconHTML("keyboard_capslock");
                    keyElement.addEventListener("click", () => {
                        if(hoa=="HOA"){
                            hoa="th";
                        }else{
                            hoa="HOA";
                        }
                        this._toggleCapsLock(lang,hoa);                        
                    });
                    break;                
                case "enter":
                    keyElement.classList.add("keyboard__key--wide");
                    keyElement.innerHTML = createIconHTML("keyboard_return");

                    keyElement.addEventListener("click", () => {
                        var settingname1 = $('#name2').val();
                        document.getElementById("settingname2").value = settingname1;
                        $('.name2').html(settingname1);
                        //$('#usernamepoint1').modal('hide');
                        
                        this.eventHandlers.oninput = oninput;
                        this.eventHandlers.onclose = onclose;
                        this.elements.main.classList.add("keyboard--hidden_mode3name2");
                        this.properties.value += "\n";
                        this._triggerEvent("oninput");
                    });

                    break;
                case "space":
                    keyElement.classList.add("keyboard__key--extra-wide");
                    keyElement.innerHTML = createIconHTML("space_bar");

                    keyElement.addEventListener("click", () => {
                        //this.properties.value += " ";
                        var x=document.getElementById("pos_char").value;
                        var length = this.properties.value.length;                
                        var str = this.properties.value;
                        var res = str.substring(0, x);
                        var res2 = str.substring(x, length); 
                        this.properties.value=res+" "+res2;     
                        document.getElementById("pos_char").value=parseInt(x)+1;
                        this._triggerEvent("oninput");
                    });
                    break;
                case "done":
                    keyElement.classList.add("keyboard__key--wide", "keyboard__key--dark");
                    keyElement.innerHTML = createIconHTML("check_circle");
                    keyElement.addEventListener("click", () => {
                        this.close();
                        this._triggerEvent("onclose");
                    });
                    break;
                case "EN":
                    keyElement.innerHTML = key;
                    keyElement.classList.add("keyboard__key--wide","keyboard__key--activatable","activatableen"); 
                    keyElement.addEventListener("click", () => {
                        this._changeLanguage("en",hoa);
                    });
                    break;
                case "KR":
                    keyElement.innerHTML = key;
                    keyElement.classList.add("keyboard__key--wide","keyboard__key--activatable","keyboard__key--active_lang","activatablekr");
                    keyElement.addEventListener("click", () => {
                        this._changeLanguage("kr",hoa);
                    });
                    break;
                case "VN":
                    keyElement.innerHTML = key;
                    keyElement.classList.add("keyboard__key--wide","keyboard__key--activatable","activatablevn");
                    keyElement.addEventListener("click", () => {
                        this._changeLanguage("vn",hoa);
                    });
                    break;
                case "language":
                    keyElement.innerHTML = createIconHTML("language");
                    keyElement.addEventListener("click", () => {
                        this._changeLanguage("en",hoa);
                    });
                break;
                default:
                    keyElement.textContent = key.toLowerCase();

                    keyElement.addEventListener("click", () => {
                        //this.properties.value += this.properties.capsLock ? key.toUpperCase() : key.toLowerCase();
                        //this.properties.value=Hangul.a(Hangul.d(this.properties.value));
                        var x=document.getElementById("pos_char").value;
                        var length = this.properties.value.length;                
                        var str = this.properties.value;
                        var res = str.substring(0, x);
                        var res2 = str.substring(x, length); 
                        var stringlength=Hangul.a(Hangul.d(res+key));                        
                        this.properties.value=stringlength+res2;                        
                        document.getElementById("pos_char").value=parseInt(stringlength.length);
                        this._triggerEvent("oninput");
                    });

                    break;
            }

            fragment.appendChild(keyElement);

            if (insertLineBreak) {
                fragment.appendChild(document.createElement("br"));
            }
        });
        }        
        return fragment;
    },
    

    _triggerEvent(handlerName) {
        if (typeof this.eventHandlers[handlerName] == "function") {
            this.eventHandlers[handlerName](this.properties.value);
        }
    },

    _toggleCapsLock(lang,hoa) {
        $(".keyboard__keysname2").html("");
        this.elements.keysContainer.appendChild(this._createKeys(lang,hoa));        
    },
    _changeLanguage(lang,hoa) {
        $(".keyboard__keysname2").html("");        
        this.elements.keysContainer.appendChild(this._createKeys(lang,hoa));
    },

    open(initialValue, oninput, onclose) {
        this.properties.value = initialValue || "";
        this.eventHandlers.oninput = oninput;
        this.eventHandlers.onclose = onclose;
        this.elements.main.classList.remove("keyboard--hidden_mode3name2");
    },

    close() {
        this.properties.value = "";
        this.eventHandlers.oninput = oninput;
        this.eventHandlers.onclose = onclose;
        this.elements.main.classList.add("keyboard--hidden_mode3name2");        
    }

    
};

window.addEventListener("DOMContentLoaded", function () {
    Keyboardmode3name2.init();
});

