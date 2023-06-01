function setInnerHTML(elm, html) {
    elm.innerHTML = html;

    Array.from(elm.querySelectorAll("script"))
        .forEach(oldScriptEl => {
            const newScriptEl = document.createElement("script");

            Array.from(oldScriptEl.attributes).forEach(attr => {
                newScriptEl.setAttribute(attr.name, attr.value)
            });

            const scriptText = document.createTextNode(oldScriptEl.innerHTML);
            newScriptEl.appendChild(scriptText);

            oldScriptEl.parentNode.replaceChild(newScriptEl, oldScriptEl);
        });
}

function tribinClearTextBox() {
    let textBoxInputList = document.getElementsByClassName('form-control')
    let textBoxInputLength = textBoxInputList.length
    for (let i = 0; i < textBoxInputLength; i++) {
        textBoxInputList[i].value = ''
    }
}

function tribinClearTextBoxByClassName(ClassName) {
    let textBoxInputList = document.getElementsByClassName(ClassName)
    let textBoxInputLength = textBoxInputList.length
    for (let i = 0; i < textBoxInputLength; i++) {
        textBoxInputList[i].value = ''
    }
}