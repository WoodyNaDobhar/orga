import{_ as h}from"./ClassicEditor.vue_vue_type_script_setup_true_lang-D0ZbiRR-.js";import{_ as g}from"./TomSelect.vue_vue_type_script_setup_true_lang-CVpV8ZFP.js";import{_}from"./Button.vue_vue_type_script_setup_true_lang-8fukZ2f8.js";import{d as v,r as p,c as y,a as o,b as t,w as a,u as e,F as x,o as b,e as s,h as i,Z as l,ac as m}from"./main-CacA-ulL.js";import{_ as d}from"./FormLabel.vue_vue_type_script_setup_true_lang-zHJCZWSc.js";const C=o("div",{class:"flex items-center mt-8 intro-y"},[o("h2",{class:"mr-auto text-lg font-medium"},"Form Layout")],-1),F={class:"grid grid-cols-12 gap-6 mt-5"},V={class:"col-span-12 intro-y lg:col-span-6"},w={class:"p-5 intro-y box"},T={class:"mt-3"},k=o("option",{value:"1"},"Sport & Outdoor",-1),B=o("option",{value:"2"},"PC & Laptop",-1),S=o("option",{value:"3"},"Smartphone & Tablet",-1),$=o("option",{value:"4"},"Photography",-1),N={class:"mt-3"},P={class:"mt-3"},U={class:"mt-3"},W={class:"grid-cols-3 gap-2 sm:grid"},I={class:"mt-3"},D=o("label",null,"Active Status",-1),L={class:"mt-3"},Q=o("label",null,"Description",-1),A={class:"mt-2"},E={class:"mt-5 text-right"},J=v({__name:"CrudForm",setup(G){const n=p(["1","3"]),f={toolbar:{items:["bold","italic","link"]}},c=p("<p>Content of the editor.</p>");return(O,r)=>(b(),y(x,null,[C,o("div",F,[o("div",V,[o("div",w,[o("div",null,[t(e(d),{htmlFor:"crud-form-1"},{default:a(()=>[s("Product Name")]),_:1}),t(e(i),{id:"crud-form-1",type:"text",class:"w-full",placeholder:"Input text"})]),o("div",T,[t(e(d),{htmlFor:"crud-form-2"},{default:a(()=>[s("Category")]),_:1}),t(e(g),{id:"crud-form-2",modelValue:n.value,"onUpdate:modelValue":r[0]||(r[0]=u=>n.value=u),class:"w-full",multiple:""},{default:a(()=>[k,B,S,$]),_:1},8,["modelValue"])]),o("div",N,[t(e(d),{htmlFor:"crud-form-3"},{default:a(()=>[s("Quantity")]),_:1}),t(e(l),null,{default:a(()=>[t(e(i),{id:"crud-form-3",type:"text",placeholder:"Quantity","aria-describedby":"input-group-1"}),t(e(l).Text,{id:"input-group-1"},{default:a(()=>[s("pcs")]),_:1})]),_:1})]),o("div",P,[t(e(d),{htmlFor:"crud-form-4"},{default:a(()=>[s("Weight")]),_:1}),t(e(l),null,{default:a(()=>[t(e(i),{id:"crud-form-4",type:"text",placeholder:"Weight","aria-describedby":"input-group-2"}),t(e(l).Text,{id:"input-group-2"},{default:a(()=>[s("grams")]),_:1})]),_:1})]),o("div",U,[t(e(d),null,{default:a(()=>[s("Price")]),_:1}),o("div",W,[t(e(l),null,{default:a(()=>[t(e(l).Text,{id:"input-group-3"},{default:a(()=>[s("Unit")]),_:1}),t(e(i),{type:"text",placeholder:"Unit","aria-describedby":"input-group-3"})]),_:1}),t(e(l),{class:"mt-2 sm:mt-0"},{default:a(()=>[t(e(l).Text,{id:"input-group-4"},{default:a(()=>[s(" Wholesale ")]),_:1}),t(e(i),{type:"text",placeholder:"Wholesale","aria-describedby":"input-group-4"})]),_:1}),t(e(l),{class:"mt-2 sm:mt-0"},{default:a(()=>[t(e(l).Text,{id:"input-group-5"},{default:a(()=>[s("Bulk")]),_:1}),t(e(i),{type:"text",placeholder:"Bulk","aria-describedby":"input-group-5"})]),_:1})])]),o("div",I,[D,t(e(m),{class:"mt-2"},{default:a(()=>[t(e(m).Input,{type:"checkbox"})]),_:1})]),o("div",L,[Q,o("div",A,[t(e(h),{modelValue:c.value,"onUpdate:modelValue":r[1]||(r[1]=u=>c.value=u),config:f},null,8,["modelValue"])])]),o("div",E,[t(e(_),{type:"button",variant:"outline-secondary",class:"w-24 mr-1"},{default:a(()=>[s(" Cancel ")]),_:1}),t(e(_),{type:"button",variant:"primary",class:"w-24"},{default:a(()=>[s(" Save ")]),_:1})])])])])],64))}});export{J as default};
