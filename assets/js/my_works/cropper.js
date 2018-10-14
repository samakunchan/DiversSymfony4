console.log('Application cropper js');
import Cropper from 'cropperjs/dist/cropper';
import Routing from '../../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.js';
import Routes from './routes.json';
import axios from 'axios';

Routing.setRoutingData(Routes);
let cropped;
let previewFile = ()=>{
  let file = document.getElementById("profil_avatar").files[0];
  let reader = new FileReader();

  reader.addEventListener('load', ()=>{
    document.getElementById("avatar").src = reader.result;
  }, false);

  if (file){
    reader.readAsDataURL(file);
    console.log('fichier chargé');
  }
};


let cropper = ()=>{
  cropped = new Cropper(document.getElementById("avatar"), {
    aspectRatio: 1/1,
    preview: '.preview',
    dragMode: 'move'
  })
};


let submitForm = (event)=>{
  event.preventDefault();
  let data = {
    maxHeight: 1000,
    maxWidth: 1000,
  };
  cropped.getCroppedCanvas(data).toBlob((blob)=>{
    ajaxWithAxios(blob);
  })
};

let ajaxWithAxios = (blob)=>{
  let data = new FormData(document.getElementById("profil_form"));
  data.append('file', blob);
  let axiosData = {
    method: 'post',
    url: Routing.generate('image'),
    data: data,
    headers: {'X-Requested-With': 'XMLHttpRequest'}
  };

  axios(axiosData)
    .then((rep)=>{console.log(rep);})
    .catch((error)=>{console.log(error);})
};
document.getElementById("profil_avatar").addEventListener('change', previewFile);
document.getElementById("avatar").addEventListener('load', cropper);

document.getElementById("profil_form").addEventListener('submit', submitForm);