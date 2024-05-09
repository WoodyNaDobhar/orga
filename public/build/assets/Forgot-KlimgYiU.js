import{d as $,R,y as S,v as C,r as g,z as L,Q as B,c as l,b as i,u as t,a as e,B as E,F as p,f as h,s as _,n as y,w as N,ah as U,e as d,o as n,d2 as A,d3 as F,h as v,t as P,C as c,E as z}from"./main-CU6Xn-QM.js";import{_ as D}from"./Button.vue_vue_type_script_setup_true_lang-CgoDilaI.js";import{u as M,r as b,e as T,m as G,a as K}from"./index-nNLSoWQs.js";import{G as O}from"./GoogleReCaptchaV3-C0PxCShu.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const q={class:y(["p-3 sm:px-8 relative h-screen lg:overflow-hidden bg-primary xl:bg-white dark:bg-darkmode-800 xl:dark:bg-darkmode-600","before:hidden before:xl:block before:content-[''] before:w-[57%] before:-mt-[28%] before:-mb-[16%] before:-ml-[13%] before:absolute before:inset-y-0 before:left-0 before:transform before:rotate-[-4.5deg] before:bg-primary/20 before:rounded-[100%] before:dark:bg-darkmode-400","after:hidden after:xl:block after:content-[''] after:w-[57%] after:-mt-[20%] after:-mb-[13%] after:-ml-[13%] after:absolute after:inset-y-0 after:left-0 after:transform after:rotate-[-4.5deg] after:bg-primary after:rounded-[100%] after:dark:bg-darkmode-700"])},Q={class:"container relative z-10 sm:px-10"},j={class:"block grid-cols-2 gap-4 xl:grid"},H={class:"flex-col hidden min-h-screen xl:flex"},I=e("a",{href:"",class:"flex items-center pt-5 -intro-x"},[e("span",{class:"ml-3 text-lg text-white"})],-1),J={class:"my-auto"},W=["src"],X=e("div",{class:"mt-10 text-4xl font-medium leading-tight text-white -intro-x"},[d(" Amtgard"),e("br"),d(" Online Record Keeper v4 ")],-1),Y=e("div",{class:"mt-5 text-lg text-white -intro-x text-opacity-70 dark:text-slate-400"}," Live the Dream! ",-1),Z={class:"flex h-screen py-5 my-10 xl:h-auto xl:py-0 xl:my-0"},ee={class:"w-full px-5 py-8 mx-auto my-auto bg-white rounded-md shadow-md xl:ml-20 dark:bg-darkmode-600 xl:bg-transparent sm:px-8 xl:p-0 xl:shadow-none sm:w-3/4 lg:w-2/4 xl:w-auto"},te=e("h2",{class:"text-2xl font-bold text-center intro-x xl:text-3xl xl:text-left"}," Forgot Password ",-1),ae={class:"mt-8 intro-x"},se={class:"flex items-center mt-4 text-xs intro-x text-slate-600 dark:text-slate-500 sm:text-sm"},re={style:{display:"inline"}},oe=e("div",{class:"mt-10 text-center intro-x xl:mt-24 text-slate-600 dark:text-slate-500 xl:text-left"},[d(" By using this service, you agree to our "),e("a",{class:"text-primary dark:text-slate-200",href:"/legal#terms"}," Terms and Conditions "),d(" & "),e("a",{class:"text-primary dark:text-slate-200",href:"/legal#privacy"}," Privacy Policy ")],-1),xe=$({__name:"Forgot",setup(le){R();const x=S();C();var m=g();const k=g(navigator.userAgent),u=L({email:"",device_name:k}),w={email:{required:b,email:T,minLength:G(5),maxLength:K(191)},device_name:{required:b}},a=M(w,B(u)),V=()=>{if(a.value.$touch(),a.value.$invalid)c(!1,"Please check the form.");else try{z.post("/api/forgot",u).then(s=>{x.storeState("success",s.data.message),c(!0,s.data.message)}).catch(s=>{x.storeState("error",s.response.data.message),console.log("Error sending login1:",s),c(!1,s.response.data.message)})}catch(s){x.storeState("error",s),console.log("Error sennding login:",s),c(!1,s)}};return(s,o)=>(n(),l("div",q,[i(t(A)),e("div",Q,[e("div",j,[e("div",H,[I,e("div",J,[e("img",{alt:"Amtgard Online Record Keeper v4",class:"w-1/2 -mt-16 -intro-x",src:t(F)},null,8,W),X,Y])]),e("div",Z,[e("div",ee,[e("form",{class:"validate-form",onSubmit:E(V,["prevent"])},[te,e("div",ae,[i(t(v),{id:"device_name",modelValue:t(a).device_name.$model,"onUpdate:modelValue":o[0]||(o[0]=r=>t(a).device_name.$model=r),modelModifiers:{trim:!0},type:"hidden",name:"device_name"},null,8,["modelValue"]),t(a).device_name.$error?(n(!0),l(p,{key:0},h(t(a).device_name.$errors,(r,f)=>(n(),l("div",{key:f,class:"mt-2 text-danger"}," Unable to determine device "))),128)):_("",!0),i(t(v),{id:"email",modelValue:t(a).email.$model,"onUpdate:modelValue":o[1]||(o[1]=r=>t(a).email.$model=r),modelModifiers:{trim:!0},type:"text",name:"email",class:y(["block px-4 py-3 intro-x login__input min-w-full xl:min-w-[350px]",{"border-danger":t(a).email.$error}]),placeholder:"Email"},null,8,["modelValue","class"]),t(a).email.$error?(n(!0),l(p,{key:1},h(t(a).email.$errors,(r,f)=>(n(),l("div",{key:f,class:"mt-2 text-danger"},P(r.$message),1))),128)):_("",!0)]),e("div",se,[i(t(D),{variant:"primary",type:"submit",class:"w-full px-4 py-3 align-top xl:w-32 xl:mr-3"},{default:N(()=>[d(" Reset ")]),_:1}),e("div",re,[i(O,{modelValue:t(m),"onUpdate:modelValue":o[2]||(o[2]=r=>U(m)?m.value=r:m=r),ref:"captcha",id:"reset_id",inline:"",action:"reset",style:{display:"inline"}},null,8,["modelValue"])])]),oe],32)])])])])]))}});export{xe as default};
