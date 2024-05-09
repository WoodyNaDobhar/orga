import{d as E,z as R,Q as T,c as r,a as s,b as o,w as l,u as e,F as c,o as m,a6 as $,e as d,B as S,h as _,n as p,f as h,t as u,s as g,_ as V,cY as L,d1 as k}from"./main-CU6Xn-QM.js";import{P as w}from"./index-BZMkVv-v.js";import{_ as N}from"./FormTextarea.vue_vue_type_script_setup_true_lang-Dp-Hjwms.js";import{_ as x}from"./FormLabel.vue_vue_type_script_setup_true_lang-Dshkjoyt.js";import{_ as M}from"./Button.vue_vue_type_script_setup_true_lang-CgoDilaI.js";import{u as P,r as v,m as y,e as U,i as A,a as O,d as B}from"./index-nNLSoWQs.js";const D=s("div",{class:"flex items-center mt-8 intro-y"},[s("h2",{class:"mr-auto text-lg font-medium"},"Form Validation")],-1),W={class:"grid grid-cols-12 gap-6 mt-5"},H={class:"col-span-12 intro-y lg:col-span-6"},z={class:"flex flex-col items-center p-5 border-b sm:flex-row border-slate-200/60 dark:border-darkmode-400"},I=s("h2",{class:"mr-auto text-base font-medium"},"Implementation",-1),j={class:"p-5"},J={class:"input-form"},Q=s("span",{class:"mt-1 text-xs sm:ml-auto sm:mt-0 text-slate-500"}," Required, at least 2 characters ",-1),X={class:"mt-3 input-form"},Y=s("span",{class:"mt-1 text-xs sm:ml-auto sm:mt-0 text-slate-500"}," Required, email address format ",-1),G={class:"mt-3 input-form"},K=s("span",{class:"mt-1 text-xs sm:ml-auto sm:mt-0 text-slate-500"}," Required, at least 6 characters ",-1),Z={class:"mt-3 input-form"},ee=s("span",{class:"mt-1 text-xs sm:ml-auto sm:mt-0 text-slate-500"}," Required, integer only & maximum 3 characters ",-1),te={class:"mt-3 input-form"},se=s("span",{class:"mt-1 text-xs sm:ml-auto sm:mt-0 text-slate-500"}," Optional, URL format ",-1),oe={class:"mt-3 input-form"},ae=s("span",{class:"mt-1 text-xs sm:ml-auto sm:mt-0 text-slate-500"}," Required, at least 10 characters ",-1),le=s("div",{class:"ml-4 mr-4"},[s("div",{class:"font-medium"},"Registration success!"),s("div",{class:"mt-1 text-slate-500"}," Please check your e-mail for further info! ")],-1),re=s("div",{class:"ml-4 mr-4"},[s("div",{class:"font-medium"},"Registration failed!"),s("div",{class:"mt-1 text-slate-500"},"Please check the fileld form.")],-1),pe=E({__name:"Validation",setup(me){const b=R({name:"",email:"",password:"",age:"",url:"",comment:""}),q={name:{required:v,minLength:y(2)},email:{required:v,email:U},password:{required:v,minLength:y(6)},age:{required:v,integer:A,maxLength:O(3)},url:{url:B},comment:{required:v,minLength:y(10)}},t=P(q,T(b)),F=()=>{if(t.value.$touch(),t.value.$invalid){const f=document.querySelectorAll("#failed-notification-content")[0].cloneNode(!0);f.classList.remove("hidden"),k({node:f,duration:3e3,newWindow:!0,close:!0,gravity:"top",position:"right",stopOnFocus:!0}).showToast()}else{const f=document.querySelectorAll("#success-notification-content")[0].cloneNode(!0);f.classList.remove("hidden"),k({node:f,duration:3e3,newWindow:!0,close:!0,gravity:"top",position:"right",stopOnFocus:!0}).showToast()}};return(f,i)=>(m(),r(c,null,[D,s("div",W,[s("div",H,[o(e(w),{class:"intro-y box"},{default:l(({toggle:C})=>[s("div",z,[I,o(e($),{class:"w-full mt-3 sm:w-auto sm:ml-auto sm:mt-0"},{default:l(()=>[o(e($).Label,{htmlFor:"show-example-1"},{default:l(()=>[d(" Show example code ")]),_:1}),o(e($).Input,{id:"show-example-1",onClick:C,class:"ml-3 mr-0",type:"checkbox"},null,8,["onClick"])]),_:2},1024)]),s("div",j,[o(e(w).Panel,null,{default:l(()=>[s("form",{class:"validate-form",onSubmit:S(F,["prevent"])},[s("div",J,[o(e(x),{htmlFor:"validation-form-1",class:"flex flex-col w-full sm:flex-row"},{default:l(()=>[d(" Name "),Q]),_:1}),o(e(_),{id:"validation-form-1",modelValue:e(t).name.$model,"onUpdate:modelValue":i[0]||(i[0]=a=>e(t).name.$model=a),modelModifiers:{trim:!0},type:"text",name:"name",class:p({"border-danger":e(t).name.$error}),placeholder:"John Legend"},null,8,["modelValue","class"]),e(t).name.$error?(m(!0),r(c,{key:0},h(e(t).name.$errors,(a,n)=>(m(),r("div",{key:n,class:"mt-2 text-danger"},u(a.$message),1))),128)):g("",!0)]),s("div",X,[o(e(x),{htmlFor:"validation-form-2",class:"flex flex-col w-full sm:flex-row"},{default:l(()=>[d(" Email "),Y]),_:1}),o(e(_),{modelValue:e(t).email.$model,"onUpdate:modelValue":i[1]||(i[1]=a=>e(t).email.$model=a),modelModifiers:{trim:!0},id:"validation-form-2",type:"email",name:"email",class:p({"border-danger":e(t).email.$error}),placeholder:"example@gmail.com"},null,8,["modelValue","class"]),e(t).email.$error?(m(!0),r(c,{key:0},h(e(t).email.$errors,(a,n)=>(m(),r("div",{key:n,class:"mt-2 text-danger"},u(a.$message),1))),128)):g("",!0)]),s("div",G,[o(e(x),{htmlFor:"validation-form-3",class:"flex flex-col w-full sm:flex-row"},{default:l(()=>[d(" Password "),K]),_:1}),o(e(_),{id:"validation-form-3",modelValue:e(t).password.$model,"onUpdate:modelValue":i[2]||(i[2]=a=>e(t).password.$model=a),modelModifiers:{trim:!0},type:"password",name:"password",class:p({"border-danger":e(t).password.$error}),placeholder:"secret"},null,8,["modelValue","class"]),e(t).password.$error?(m(!0),r(c,{key:0},h(e(t).password.$errors,(a,n)=>(m(),r("div",{key:n,class:"mt-2 text-danger"},u(a.$message),1))),128)):g("",!0)]),s("div",Z,[o(e(x),{htmlFor:"validation-form-4",class:"flex flex-col w-full sm:flex-row"},{default:l(()=>[d(" Age "),ee]),_:1}),o(e(_),{id:"validation-form-4",modelValue:e(t).age.$model,"onUpdate:modelValue":i[3]||(i[3]=a=>e(t).age.$model=a),type:"number",name:"age",class:p({"border-danger":e(t).age.$error}),placeholder:"21"},null,8,["modelValue","class"]),e(t).age.$error?(m(!0),r(c,{key:0},h(e(t).age.$errors,(a,n)=>(m(),r("div",{key:n,class:"mt-2 text-danger"},u(a.$message),1))),128)):g("",!0)]),s("div",te,[o(e(x),{htmlFor:"validation-form-5",class:"flex flex-col w-full sm:flex-row"},{default:l(()=>[d(" Profile URL "),se]),_:1}),o(e(_),{id:"validation-form-5",modelValue:e(t).url.$model,"onUpdate:modelValue":i[4]||(i[4]=a=>e(t).url.$model=a),modelModifiers:{trim:!0},type:"text",name:"url",class:p({"border-danger":e(t).url.$error}),placeholder:"https://google.com"},null,8,["modelValue","class"]),e(t).url.$error?(m(!0),r(c,{key:0},h(e(t).url.$errors,(a,n)=>(m(),r("div",{key:n,class:"mt-2 text-danger"},u(a.$message),1))),128)):g("",!0)]),s("div",oe,[o(e(x),{htmlFor:"validation-form-6",class:"flex flex-col w-full sm:flex-row"},{default:l(()=>[d(" Comment "),ae]),_:1}),o(e(N),{id:"validation-form-6",modelValue:e(t).comment.$model,"onUpdate:modelValue":i[5]||(i[5]=a=>e(t).comment.$model=a),modelModifiers:{trim:!0},name:"comment",class:p({"border-danger":e(t).comment.$error}),placeholder:"Type your comments"},null,8,["modelValue","class"]),e(t).comment.$error?(m(!0),r(c,{key:0},h(e(t).comment.$errors,(a,n)=>(m(),r("div",{key:n,class:"mt-2 text-danger"},u(a.$message),1))),128)):g("",!0)]),o(e(M),{variant:"primary",type:"submit",class:"mt-5"},{default:l(()=>[d(" Register ")]),_:1})],32)]),_:1}),o(e(w).Panel,{type:"source"},{default:l(()=>[o(e(w).Highlight,{type:"javascript"},{default:l(()=>[d(u(`
                const formData = reactive({
                    name: "",
                    email: "",
                    password: "",
                    age: "",
                    url: "",
                    comment: "",
                    });

                    const rules = {
                    name: {
                        required,
                        minLength: minLength(2),
                    },
                    email: {
                        required,
                        email,
                    },
                    password: {
                        required,
                        minLength: minLength(6),
                    },
                    age: {
                        required,
                        integer,
                        maxLength: maxLength(3),
                    },
                    url: {
                        url,
                    },
                    comment: {
                        required,
                        minLength: minLength(10),
                    },
                };

                const validate = useVuelidate(rules, toRefs(formData));

                const onSubmit = () => {
                    validate.value.$touch();
                    if (validate.value.$invalid) {
                        const failedEl = document
                        .querySelectorAll("#failed-notification-content")[0]
                        .cloneNode(true) as HTMLElement;
                        failedEl.classList.remove("hidden");
                        Toastify({
                        node: failedEl,
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "right",
                        stopOnFocus: true,
                        }).showToast();
                    } else {
                        const successEl = document
                        .querySelectorAll("#success-notification-content")[0]
                        .cloneNode(true) as HTMLElement;
                        successEl.classList.remove("hidden");
                        Toastify({
                        node: successEl,
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "right",
                        stopOnFocus: true,
                        }).showToast();
                    }
                };
                `),1)]),_:1})]),_:1})])]),_:1}),o(e(L),{id:"success-notification-content",class:"flex hidden"},{default:l(()=>[o(e(V),{icon:"CheckCircle",class:"text-success"}),le]),_:1}),o(e(L),{id:"failed-notification-content",class:"flex hidden"},{default:l(()=>[o(e(V),{icon:"XCircle",class:"text-danger"}),re]),_:1})])])],64))}});export{pe as default};
