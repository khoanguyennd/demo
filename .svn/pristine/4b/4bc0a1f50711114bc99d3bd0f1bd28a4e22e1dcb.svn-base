const Keyboardnumberm = {
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
        this.elements.main.classList.add("keyboard_number", "keyboard--hidden_number");
        this.elements.keysContainer.classList.add("keyboard__keysnumber");
        this.elements.keysContainer.appendChild(this._createKeys());

        this.elements.keys = this.elements.keysContainer.querySelectorAll(".keyboard__key");

        // Add to DOM
        this.elements.main.appendChild(this.elements.keysContainer);
        document.body.appendChild(this.elements.main);

        // Automatically use keyboard for elements with .use-keyboard-input
        document.querySelectorAll(".use-keyboard-number").forEach(element => {
            /*element.addEventListener("focus", () => {
                this.open(element.value, currentValue => {
                    element.value = currentValue;                                        
                });
            });*/
            element.addEventListener("click", () => {
                //console.log(event);
                var length = element.value.length;
                var x = length - (length - element.selectionStart);
                var str = element.value;
                var res = str.substring(0, x);
                var res2 = str.substring(x, length);
                document.getElementById("pos_number").value=x;                
                this.open(element.value, currentValue => {
                    element.value=currentValue;
                });
            });
        });    

        document.addEventListener( "click", someListener );
        function someListener(event){
        	var element =event.target;
        	//console.log(element)
        	if(element.classList.contains("use-keyboard-number") || element.classList.contains("material-icons") || element.classList.contains("keyboard__key") || element.classList.contains("keyboard__keysnumber")){
	        	
        	}else{
                var keyboard=document.querySelector(".keyboard_number");
	            keyboard.classList.add("keyboard--hidden_number");
        	}
           
        }
        
    },

    _createKeys() {
        const fragment = document.createDocumentFragment();
        const keyLayout = [
            "1", "2", "3", "4", "5", "6","7", "8", "9","backspace", "0", "done",
        ];

        // Creates HTML for an icon
        const createIconHTML = (icon_name) => {
            return `<i class="material-icons">${icon_name}</i>`;
        };

        keyLayout.forEach(key => {
            const keyElement = document.createElement("button");
            const insertLineBreak = ["3", "6", "9"].indexOf(key) !== -1;

            // Add attributes/classes
            keyElement.setAttribute("type", "button");
            keyElement.classList.add("keyboard__key");
            keyElement.classList.add("keyboard__key"+key);

            switch (key) {
                case "":
                    keyElement.classList.add("keyboard__key_empty");
                    break;
                case "backspace":
                    keyElement.classList.add("keyboard__key--wide");
                    keyElement.innerHTML = createIconHTML("backspace");

                    keyElement.addEventListener("click", () => {
                        this.properties.value = this.properties.value.substring(0, this.properties.value.length - 1);
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
                default:
                    keyElement.textContent = key.toLowerCase();
                    keyElement.addEventListener("click", () => {
                        //this.properties.value += this.properties.capsLock ? key.toUpperCase() : key.toLowerCase();
                        var x=document.getElementById("pos_number").value;
                        var length = this.properties.value.length;                
                        var str = this.properties.value;
                        var res = str.substring(0, x);
                        var res2 = str.substring(x, length);
                        this.properties.value=res+key+res2;
                        document.getElementById("pos_number").value=parseInt(x)+1;
                        this._triggerEvent("oninput");
                    });
                    
                    break;
            }

            fragment.appendChild(keyElement);

            if (insertLineBreak) {
                fragment.appendChild(document.createElement("br"));
            }
        });

        return fragment;
    },

    _triggerEvent(handlerName) {
        if (typeof this.eventHandlers[handlerName] == "function") {
            this.eventHandlers[handlerName](this.properties.value);
        }
    },

    _toggleCapsLock() {
        this.properties.capsLock = !this.properties.capsLock;

        for (const key of this.elements.keys) {
            if (key.childElementCount === 0) {
                key.textContent = this.properties.capsLock ? key.textContent.toUpperCase() : key.textContent.toLowerCase();
            }
        }
    },

    open(initialValue, oninput, onclose) {
        this.properties.value = initialValue || "";
        this.eventHandlers.oninput = oninput;
        this.eventHandlers.onclose = onclose;
        this.elements.main.classList.remove("keyboard--hidden_number");
    },

    close() {
        this.properties.value = "";
        this.eventHandlers.oninput = oninput;
        this.eventHandlers.onclose = onclose;
        this.elements.main.classList.add("keyboard--hidden_number");        
    }

    
};

window.addEventListener("DOMContentLoaded", function () {
    Keyboardnumberm.init();

});

