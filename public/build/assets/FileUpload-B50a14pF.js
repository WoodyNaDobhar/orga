import{P as l}from"./index-BKRdGgjI.js";import{_ as p}from"./Dropzone.vue_vue_type_script_setup_true_lang-BjNK38RF.js";import{d as _,r as c,O as x,c as g,a as t,b as e,w as s,u as o,F as z,o as b,a6 as i,e as a,t as m}from"./main-Cq9G9OfL.js";import"./Button.vue_vue_type_script_setup_true_lang-B0f2KFnz.js";const v=t("div",{class:"flex items-center mt-8 intro-y"},[t("h2",{class:"mr-auto text-lg font-medium"},"Dropzone")],-1),y={class:"grid grid-cols-12 gap-6 mt-5"},w={class:"col-span-12 intro-y lg:col-span-6"},k={class:"flex flex-col items-center p-5 border-b sm:flex-row border-slate-200/60 dark:border-darkmode-400"},F=t("h2",{class:"mr-auto text-base font-medium"},"Single File Upload",-1),D={class:"p-5"},S=t("div",{class:"text-lg font-medium"}," Drop files here or click to upload. ",-1),M=t("div",{class:"text-gray-600"},[a(" This is just a demo dropzone. Selected files are "),t("span",{class:"font-medium"},"not"),a(" actually uploaded. ")],-1),R={class:"flex flex-col items-center p-5 border-b sm:flex-row border-slate-200/60 dark:border-darkmode-400"},j=t("h2",{class:"mr-auto text-base font-medium"},"Multiple File Upload",-1),C={class:"p-5"},A=t("div",{class:"text-lg font-medium"}," Drop files here or click to upload. ",-1),H=t("div",{class:"text-gray-600"},[a(" This is just a demo dropzone. Selected files are "),t("span",{class:"font-medium"},"not"),a(" actually uploaded. ")],-1),P={class:"flex flex-col items-center p-5 border-b sm:flex-row border-slate-200/60 dark:border-darkmode-400"},T=t("h2",{class:"mr-auto text-base font-medium"},"File Type Validation",-1),V={class:"p-5"},K=t("div",{class:"text-lg font-medium"}," Drop files here or click to upload. ",-1),N=t("div",{class:"text-gray-600"},[a(" This is just a demo dropzone. Selected files are "),t("span",{class:"font-medium"},"not"),a(" actually uploaded. ")],-1),E=_({__name:"FileUpload",setup(W){const u=c(),f=c(),h=c();return x(()=>{const r=u.value;r&&(r.dropzone.on("success",()=>{alert("Added file.")}),r.dropzone.on("error",()=>{alert("No more files please!")}));const n=f.value;n&&(n.dropzone.on("success",()=>{alert("Added file.")}),n.dropzone.on("error",()=>{alert("No more files please!")}));const d=h.value;d&&(d.dropzone.on("success",()=>{alert("Added file.")}),d.dropzone.on("error",()=>{alert("No more files please!")}))}),(r,n)=>(b(),g(z,null,[v,t("div",y,[t("div",w,[e(o(l),{class:"intro-y box"},{default:s(({toggle:d})=>[t("div",k,[F,e(o(i),{class:"w-full mt-3 sm:w-auto sm:ml-auto sm:mt-0"},{default:s(()=>[e(o(i).Label,{htmlFor:"show-example-1"},{default:s(()=>[a(" Show example code ")]),_:1}),e(o(i).Input,{id:"show-example-1",onClick:d,class:"ml-3 mr-0",type:"checkbox"},null,8,["onClick"])]),_:2},1024)]),t("div",D,[e(o(l).Panel,null,{default:s(()=>[e(o(p),{refKey:"dropzoneSingleRef",options:{url:"https://httpbin.org/post",thumbnailWidth:150,maxFilesize:.5,maxFiles:1,headers:{"My-Awesome-Header":"header value"}},class:"dropzone"},{default:s(()=>[S,M]),_:1},8,["options"])]),_:1}),e(o(l).Panel,{type:"source"},{default:s(()=>[e(o(l).Highlight,null,{default:s(()=>[a(m(`
              <Dropzone
                refKey="dropzoneSingleRef"
                :options="{
                  url: 'https://httpbin.org/post',
                  thumbnailWidth: 150,
                  maxFilesize: 0.5,
                  maxFiles: 1,
                  headers: { 'My-Awesome-Header': 'header value' },
                }"
                class="dropzone"
              >
                <div class="text-lg font-medium">
                  Drop files here or click to upload.
                </div>
                <div class="text-gray-600">
                  This is just a demo dropzone. Selected files are
                  <span class="font-medium">not</span> actually uploaded.
                </div>
              </Dropzone>
              `),1)]),_:1})]),_:1})])]),_:1}),e(o(l),{class:"mt-5 intro-y box"},{default:s(({toggle:d})=>[t("div",R,[j,e(o(i),{class:"w-full mt-3 sm:w-auto sm:ml-auto sm:mt-0"},{default:s(()=>[e(o(i).Label,{htmlFor:"show-example-2"},{default:s(()=>[a(" Show example code ")]),_:1}),e(o(i).Input,{id:"show-example-2",onClick:d,class:"ml-3 mr-0",type:"checkbox"},null,8,["onClick"])]),_:2},1024)]),t("div",C,[e(o(l).Panel,null,{default:s(()=>[e(o(p),{refKey:"dropzoneMultipleRef",options:{url:"https://httpbin.org/post",thumbnailWidth:150,maxFilesize:.5,headers:{"My-Awesome-Header":"header value"}},class:"dropzone"},{default:s(()=>[A,H]),_:1},8,["options"])]),_:1}),e(o(l).Panel,{type:"source"},{default:s(()=>[e(o(l).Highlight,null,{default:s(()=>[a(m(`
              <Dropzone
                refKey="dropzoneMultipleRef"
                :options="{
                  url: 'https://httpbin.org/post',
                  thumbnailWidth: 150,
                  maxFilesize: 0.5,
                  headers: { 'My-Awesome-Header': 'header value' },
                }"
                class="dropzone"
              >
                <div class="text-lg font-medium">
                  Drop files here or click to upload.
                </div>
                <div class="text-gray-600">
                  This is just a demo dropzone. Selected files are
                  <span class="font-medium">not</span> actually uploaded.
                </div>
              </Dropzone>
              `),1)]),_:1})]),_:1})])]),_:1}),e(o(l),{class:"mt-5 intro-y box"},{default:s(({toggle:d})=>[t("div",P,[T,e(o(i),{class:"w-full mt-3 sm:w-auto sm:ml-auto sm:mt-0"},{default:s(()=>[e(o(i).Label,{htmlFor:"show-example-3"},{default:s(()=>[a(" Show example code ")]),_:1}),e(o(i).Input,{id:"show-example-3",onClick:d,class:"ml-3 mr-0",type:"checkbox"},null,8,["onClick"])]),_:2},1024)]),t("div",V,[e(o(l).Panel,null,{default:s(()=>[e(o(p),{refKey:"dropzoneValidationRef",options:{url:"https://httpbin.org/post",thumbnailWidth:150,maxFilesize:.5,acceptedFiles:"image/jpeg|image/png|image/jpg",headers:{"My-Awesome-Header":"header value"}},class:"dropzone"},{default:s(()=>[K,N]),_:1},8,["options"])]),_:1}),e(o(l).Panel,{type:"source"},{default:s(()=>[e(o(l).Highlight,null,{default:s(()=>[a(m(`
              <Dropzone
                refKey="dropzoneValidationRef"
                :options="{
                  url: 'https://httpbin.org/post',
                  thumbnailWidth: 150,
                  maxFilesize: 0.5,
                  acceptedFiles: 'image/jpeg|image/png|image/jpg',
                  headers: { 'My-Awesome-Header': 'header value' },
                }"
                class="dropzone"
              >
                <div class="text-lg font-medium">
                  Drop files here or click to upload.
                </div>
                <div class="text-gray-600">
                  This is just a demo dropzone. Selected files are
                  <span class="font-medium">not</span> actually uploaded.
                </div>
              </Dropzone>
              `),1)]),_:1})]),_:1})])]),_:1})])])],64))}});export{E as default};
