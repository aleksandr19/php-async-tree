
    function assignEv() {
        dropdownRoot = document.getElementById ("horiz-menu");
        for (i=0; i < dropdownRoot.childNodes.length; i++) {
            node = dropdownRoot.childNodes [i];
            if (node.nodeName == "li") {
                node.onmouseover.style.background = "#000000";
                node.onmouseout.style.background  = "#242F33";
            }
        }
    }
