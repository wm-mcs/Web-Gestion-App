const onKeyPressEscapeCerrarModalMixIn = {
	created() {
        let vue = this;

        document.addEventListener('keyup', function (evt) {
            if (evt.keyCode === 27) {
                vue.showModal = false;
            }
        });
    },
};
