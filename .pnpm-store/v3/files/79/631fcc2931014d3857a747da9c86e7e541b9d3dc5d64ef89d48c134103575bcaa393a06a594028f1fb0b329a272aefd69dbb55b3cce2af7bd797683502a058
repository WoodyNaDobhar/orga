(function(){"use strict";try{if(typeof document!="undefined"){var r=document.createElement("style");r.appendChild(document.createTextNode(".po-password-strength-bar{border-radius:2px;transition:all .2s linear;height:5px;margin-top:8px}.po-password-strength-bar.risky{background-color:#f95e68;width:10%}.po-password-strength-bar.guessable{background-color:#fb964d;width:32.5%}.po-password-strength-bar.weak{background-color:#fdd244;width:55%}.po-password-strength-bar.safe{background-color:#b0dc53;width:77.5%}.po-password-strength-bar.secure{background-color:#35cc62;width:100%}")),document.head.appendChild(r)}}catch(o){console.error("vite-plugin-css-injected-by-js",o)}})();
import { openBlock as m, createElementBlock as _, normalizeClass as C } from "vue";
const x = [
  "123456",
  "qwerty",
  "password",
  "111111",
  "Abc123",
  "123456789",
  "12345678",
  "123123",
  "1234567890",
  "12345",
  "1234567",
  "qwertyuiop",
  "qwerty123",
  "1q2w3e",
  "password1",
  "123321",
  "Iloveyou",
  "12345"
], y = (e) => x.includes(e), i = (e) => {
  let t = 0, s = 0, r = 0, o = 0, n = 0;
  const h = /[^A-Za-z0-9]/g, d = /(.*[a-z].*)/g, p = /(.*[A-Z].*)/g, w = /(.*[0-9].*)/g, g = /(\w)(\1+\1+\1+\1+)/g, f = h.test(e), c = d.test(e), a = p.test(e), l = w.test(e), u = g.test(e);
  if (e.length > 4) {
    if (y(e))
      return 0;
    (c || a) && l && (n = 1), a && c && (o = 1), (c || a || l) && f && (r = 1), e.length > 8 && (s = 1), e.length > 12 && !u && (s = 2), e.length > 20 && !u && (s = 3), t = s + r + o + n, t > 4 && (t = 4);
  }
  return t;
}, k = (e) => {
  switch (e) {
    case 0:
      return "risky";
    case 1:
      return "guessable";
    case 2:
      return "weak";
    case 3:
      return "safe";
    case 4:
      return "secure";
    default:
      return "";
  }
}, v = (e) => {
  const t = i(e);
  return k(t);
}, R = {
  name: "PasswordMeter",
  props: {
    password: String
  },
  emits: ["score"],
  computed: {
    passwordClass() {
      if (!this.password)
        return null;
      const e = v(this.password), t = i(this.password);
      return this.$emit("score", { score: t, strength: e }), {
        [e]: !0,
        scored: !0
      };
    }
  }
};
const b = (e, t) => {
  const s = e.__vccOpts || e;
  for (const [r, o] of t)
    s[r] = o;
  return s;
};
function M(e, t, s, r, o, n) {
  return m(), _("div", {
    class: C(["po-password-strength-bar", n.passwordClass])
  }, null, 2);
}
const q = /* @__PURE__ */ b(R, [["render", M]]);
export {
  q as default
};
