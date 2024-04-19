import{d as M,r as h,m as A,q as N,x as B,b6 as E,c as o,b as n,u as e,a as s,G as F,F as m,f as c,z as p,n as g,e as u,w as T,a7 as z,y as D,b8 as G,o as l,b9 as I,ba as q,h as x,t as b,R as K,J as k,v as O}from"./main-Ol0gOx4f.js";import{_ as J}from"./Button.vue_vue_type_script_setup_true_lang-73ahc3CJ.js";import{u as Y,r as f,e as j,m as y,a as $,s as H}from"./index-C3rkOtmA.js";import{P as Q}from"./vue-simple-password-meter.umd-K8zGDDyq.js";import{G as W}from"./GoogleReCaptchaV3-C0a4Enjg.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const X={class:g(["p-3 sm:px-8 relative h-screen lg:overflow-hidden bg-primary xl:bg-white dark:bg-darkmode-800 xl:dark:bg-darkmode-600","before:hidden before:xl:block before:content-[''] before:w-[57%] before:-mt-[28%] before:-mb-[16%] before:-ml-[13%] before:absolute before:inset-y-0 before:left-0 before:transform before:rotate-[-4.5deg] before:bg-primary/20 before:rounded-[100%] before:dark:bg-darkmode-400","after:hidden after:xl:block after:content-[''] after:w-[57%] after:-mt-[20%] after:-mb-[13%] after:-ml-[13%] after:absolute after:inset-y-0 after:left-0 after:transform after:rotate-[-4.5deg] after:bg-primary after:rounded-[100%] after:dark:bg-darkmode-700"])},Z={class:"container relative z-10 sm:px-10"},ee={class:"block grid-cols-2 gap-4 xl:grid"},te={class:"flex-col hidden min-h-screen xl:flex"},re=s("a",{href:"",class:"flex items-center pt-5 -intro-x"},[s("span",{class:"ml-3 text-lg text-white"})],-1),se={class:"my-auto"},ae=["src"],oe=s("div",{class:"mt-10 text-4xl font-medium leading-tight text-white -intro-x"},[u(" Amtgard"),s("br"),u(" Online Record Keeper v4 ")],-1),le=s("div",{class:"mt-5 text-lg text-white -intro-x text-opacity-70 dark:text-slate-400"}," Live the Dream! ",-1),de={class:"flex h-screen py-5 my-10 xl:h-auto xl:py-0 xl:my-0"},ie={class:"w-full px-5 py-8 mx-auto my-auto bg-white rounded-md shadow-md xl:ml-20 dark:bg-darkmode-600 xl:bg-transparent sm:px-8 xl:p-0 xl:shadow-none sm:w-3/4 lg:w-2/4 xl:w-auto"},ne=s("h2",{class:"text-2xl font-bold text-center intro-x xl:text-3xl xl:text-left"}," Reset Password ",-1),me={class:"mt-8 intro-x"},ce={class:"flex items-center mt-4 text-xs intro-x text-slate-600 dark:text-slate-500 sm:text-sm"},pe=s("label",{class:"cursor-pointer select-none",htmlFor:"remember-me"}," I agree to the ",-1),ue=s("a",{class:"ml-1 text-primary dark:text-slate-200",href:"/legal",target:"_blank"}," Privacy Policy & Terms of Use ",-1),xe={class:"flex items-center mt-4 text-xs intro-x text-slate-600 dark:text-slate-500 sm:text-sm"},fe={style:{display:"inline"}},ge=s("div",{class:"mt-10 text-center intro-x xl:mt-24 text-slate-600 dark:text-slate-500 xl:text-left"},[u(" By using this service, you agree to our "),s("a",{class:"text-primary dark:text-slate-200",href:"/legal#terms",target:"_blank"}," Terms and Conditions "),u(" & "),s("a",{class:"text-primary dark:text-slate-200",href:"/legal#privacy"}," Privacy Policy ")],-1),$e=M({__name:"Reset",setup(_e){const V=D(),R=G(),U=h(V.params.password_token),P=h(navigator.userAgent),w=A(),C=N();var _=h();const v=B({email:"",password_token:U.value,device_name:P,password:"",password_confirm:"",is_agreed:0}),L={email:{required:f,email:j,minLength:y(5),maxLength:$(191)},password_token:{required:f},device_name:{required:f},password:{required:f,minLength:y(6)},password_confirm:{required:f,minLength:y(6),maxLength:$(191)},is_agreed:{sameAs:H(!0)}},t=Y(L,E(v)),S=()=>{if(t.value.$touch(),t.value.$invalid)k(!1,"Please check the form.");else try{O.post("/api/reset",v).then(d=>{w.storeState("success",d.data.message);const a=d.data.data.token,r=d.data.data;C.storeLoggedInUser(a,r),R.push("/")}).catch(d=>{w.storeState("error",d.response.data.message),console.log("Error sending registration:",d),k(!1,d.response.data.message)})}catch(d){w.storeState("error",d),console.log("Error sending registration:",d),k(!1,d)}};return(d,a)=>(l(),o("div",X,[n(e(I)),s("div",Z,[s("div",ee,[s("div",te,[re,s("div",se,[s("img",{alt:"Amtgard Online Record Keeper v4",class:"w-1/2 -mt-16 -intro-x",src:e(q)},null,8,ae),oe,le])]),s("div",de,[s("div",ie,[s("form",{class:"validate-form",onSubmit:F(S,["prevent"])},[ne,s("div",me,[n(e(x),{id:"password_token",modelValue:e(t).password_token.$model,"onUpdate:modelValue":a[0]||(a[0]=r=>e(t).password_token.$model=r),modelModifiers:{trim:!0},type:"hidden",name:"password_token"},null,8,["modelValue"]),e(t).password_token.$error?(l(!0),o(m,{key:0},c(e(t).password_token.$errors,(r,i)=>(l(),o("div",{key:i,class:"mt-2 text-danger"}," No reset token detected "))),128)):p("",!0),n(e(x),{id:"device_name",modelValue:e(t).device_name.$model,"onUpdate:modelValue":a[1]||(a[1]=r=>e(t).device_name.$model=r),modelModifiers:{trim:!0},type:"hidden",name:"device_name"},null,8,["modelValue"]),e(t).device_name.$error?(l(!0),o(m,{key:1},c(e(t).device_name.$errors,(r,i)=>(l(),o("div",{key:i,class:"mt-2 text-danger"}," Unable to determine device "))),128)):p("",!0),n(e(x),{id:"email",modelValue:e(t).email.$model,"onUpdate:modelValue":a[2]||(a[2]=r=>e(t).email.$model=r),modelModifiers:{trim:!0},type:"text",name:"email",class:g(["block px-4 py-3 intro-x login__input min-w-full xl:min-w-[350px]",{"border-danger":e(t).email.$error}]),placeholder:"Email"},null,8,["modelValue","class"]),e(t).email.$error?(l(!0),o(m,{key:2},c(e(t).email.$errors,(r,i)=>(l(),o("div",{key:i,class:"mt-2 text-danger"},b(r.$message),1))),128)):p("",!0),n(e(x),{id:"password",modelValue:e(t).password.$model,"onUpdate:modelValue":a[3]||(a[3]=r=>e(t).password.$model=r),modelModifiers:{trim:!0},type:"password",name:"password",class:g(["block px-4 py-3 mt-4 intro-x login__input min-w-full xl:min-w-[350px]",{"border-danger":e(t).password.$error}]),placeholder:"Password"},null,8,["modelValue","class"]),n(e(Q),{password:e(t).password.$model},null,8,["password"]),e(t).password.$error?(l(!0),o(m,{key:3},c(e(t).password.$errors,(r,i)=>(l(),o("div",{key:i,class:"mt-2 text-danger"},b(r.$message),1))),128)):p("",!0),n(e(x),{id:"password_confirm",modelValue:e(t).password_confirm.$model,"onUpdate:modelValue":a[4]||(a[4]=r=>e(t).password_confirm.$model=r),modelModifiers:{trim:!0},type:"password",name:"password_confirm",class:g(["block px-4 py-3 mt-4 intro-x login__input min-w-full xl:min-w-[350px]",{"border-danger":e(t).password_confirm.$error}]),placeholder:"Confirm Password"},null,8,["modelValue","class"]),e(t).password_confirm.$error?(l(!0),o(m,{key:4},c(e(t).password_confirm.$errors,(r,i)=>(l(),o("div",{key:i,class:"mt-2 text-danger"},b(r.$message),1))),128)):p("",!0)]),s("div",ce,[n(e(K).Input,{id:"is_agreed",modelValue:e(t).is_agreed.$model,"onUpdate:modelValue":a[5]||(a[5]=r=>e(t).is_agreed.$model=r),modelModifiers:{trim:!0},type:"checkbox",name:"is_agreed",class:g(["mr-2 border",{"border-danger":e(t).is_agreed.$error}])},null,8,["modelValue","class"]),e(t).is_agreed.$error?(l(!0),o(m,{key:0},c(e(t).is_agreed.$errors,(r,i)=>(l(),o("div",{key:i,class:"mt-2 text-danger"}," You must agree to use the service "))),128)):p("",!0),pe,ue,u(" . ")]),s("div",xe,[n(e(J),{variant:"primary",type:"submit",class:"w-full px-4 py-3 align-top xl:w-32 xl:mr-3"},{default:T(()=>[u(" Update Password ")]),_:1}),s("div",fe,[n(W,{modelValue:e(_),"onUpdate:modelValue":a[6]||(a[6]=r=>z(_)?_.value=r:_=r),ref:"captcha",id:"reset_id",inline:"",action:"reset",style:{display:"inline"}},null,8,["modelValue"])])]),ge],32)])])])])]))}});export{$e as default};
