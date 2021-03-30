const onKeyPressEscapeCerrarModalMixIn = {
  created() {
    let vue = this;

    document.addEventListener("keyup", function(evt) {
      if (evt.keyCode === 27) {
        if (vue.handlerClose) {
          console.log("Existe");
        } else {
          console.log("no exites funcion");
        }
        vue.showModal = false;
      }
    });
  }
};
