import Cropper from 'cropperjs/dist/cropper';
let each =  (arr, callback)=> {
  let length = arr.length;
  let i;
  for (i = 0; i < length; i++) {
    callback.call(arr, arr[i], i, arr);
  }
  return arr;
};
document.getElementById("profil_avatar").addEventListener('change', function () {
  console.log('Activation du preview');
  let image = document.querySelector('.image');
  let previews = document.querySelectorAll('.preview');
  let cropper = new Cropper(image, {
    ready: function () {
      let clone = this.cloneNode();
      clone.className = '';
      clone.style.cssText = (
        'display: block;' +
        'width: 100%;' +
        'min-width: 0;' +
        'min-height: 0;' +
        'max-width: none;' +
        'max-height: none;'
      );
      each(previews, function (elem) {
        elem.appendChild(clone.cloneNode());
      });
    },
    crop: function (event) {
      let data = event.detail;
      let cropper = this.cropper;
      let imageData = cropper.getImageData();
      let previewAspectRatio = data.width / data.height;
      each(previews, function (elem) {
        let previewImage = elem.getElementsByTagName('img').item(0);
        let previewWidth = elem.offsetWidth;
        let previewHeight = previewWidth / previewAspectRatio;
        let imageScaledRatio = data.width / previewWidth;
        elem.style.height = previewHeight + 'px';
        previewImage.style.width = imageData.naturalWidth / imageScaledRatio + 'px';
        previewImage.style.height = imageData.naturalHeight / imageScaledRatio + 'px';
        previewImage.style.marginLeft = -data.x / imageScaledRatio + 'px';
        previewImage.style.marginTop = -data.y / imageScaledRatio + 'px';
      });
    },
  });
});