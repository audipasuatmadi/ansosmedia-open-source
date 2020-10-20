let sideBarOpen = false;

let sideBar = document.getElementById('sidebar');
let hmbMenu = document.getElementById('hamburgermenu').getElementsByTagName('img')[0];
var inputTag = document.getElementById('upload-image');
var imgPrvTag = document.getElementById('image-preview');
var relayButton = document.getElementById('relay-button');

function getSideBar() {
	if (sideBarOpen == false) {
		sideBarOpen = true;

		sideBar.classList.remove('hide');
		hmbMenu.classList.add('onSidebar');
	} else {
		sideBarOpen = false;
		sideBar.classList.add('hide');
		hmbMenu.classList.remove('onSidebar');
	}
}

function onUploadImageClick(event) {
	if (imgPrvTag.classList.contains('noImage')){
		inputTag.click();
	} else {
		onPreviewImage(event);
	}
}

function onPreviewImage(event) {
	if (imgPrvTag.classList.contains('noImage')) {
		var reader = new FileReader();

		if (imgPrvTag.classList.contains('noImage')) {
			imgPrvTag.classList.remove('noImage');
		}

		reader.onload = function() {
			if (reader.readyState == 2) {
				imgPrvTag.style.backgroundImage = 'url("'+ reader.result +'")';
			}
		}
		reader.readAsDataURL(event.target.files[0]);

		relayButton.innerText = "hapus foto";
	} else {
		imgPrvTag.value = "";
		imgPrvTag.classList.add('noImage');
		relayButton.innerText = "tambahkan foto";
	}
}
