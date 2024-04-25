import { defineComponent as Fe, inject as pe, ref as be, reactive as we, toRef as Oe, onBeforeMount as Ae, onMounted as Pe, watchEffect as Ye, onBeforeUnmount as Le, computed as D, watch as w, openBlock as ze, createElementBlock as ye, normalizeClass as Re, unref as Y, normalizeStyle as Xe, renderSlot as _e, createCommentVNode as qe } from "vue";
import { isNull as S, nextTickOnce as f, throttle as ve } from "@vexip-ui/utils";
import { LAYOUT_KEY as je, EMITTER_KEY as $e, setTransformRtl as Ge, setTransform as Ke, setTopRight as Ve, setTopLeft as Je, useNameHelper as Qe } from "../helpers/common.mjs";
import { getControlPosition as Se, createCoreData as xe } from "../helpers/draggable.mjs";
import { getColsFromBreakpoint as Ze } from "../helpers/responsive.mjs";
import { getDocumentDir as He } from "../helpers/dom.mjs";
import Me from "interactjs";
const ot = /* @__PURE__ */ Fe({
  __name: "grid-item",
  props: {
    isDraggable: {
      type: Boolean,
      default: null
    },
    isResizable: {
      type: Boolean,
      default: null
    },
    isBounded: {
      type: Boolean,
      default: null
    },
    static: {
      type: Boolean,
      default: !1
    },
    minH: {
      type: Number,
      default: 1
    },
    minW: {
      type: Number,
      default: 1
    },
    maxH: {
      type: Number,
      default: 1 / 0
    },
    maxW: {
      type: Number,
      default: 1 / 0
    },
    x: {
      type: Number,
      required: !0
    },
    y: {
      type: Number,
      required: !0
    },
    w: {
      type: Number,
      required: !0
    },
    h: {
      type: Number,
      required: !0
    },
    i: {
      type: [Number, String],
      required: !0
    },
    dragIgnoreFrom: {
      type: String,
      default: "a, button"
    },
    dragAllowFrom: {
      type: String,
      default: null
    },
    resizeIgnoreFrom: {
      type: String,
      default: "a, button"
    },
    preserveAspectRatio: {
      type: Boolean,
      default: !1
    },
    dragOption: {
      type: Object,
      default: () => ({})
    },
    resizeOption: {
      type: Object,
      default: () => ({})
    }
  },
  emits: ["container-resized", "resize", "resized", "move", "moved"],
  setup(We, { expose: Be, emit: M }) {
    const i = We, l = pe(je), g = pe($e);
    if (!l)
      throw new Error("[grid-layout-plus]: missing layout store, GridItem must under a GridLayout.");
    const u = be(null), e = we({
      cols: 1,
      containerWidth: 100,
      rowHeight: 30,
      margin: [10, 10],
      maxRows: 1 / 0,
      draggable: null,
      resizable: null,
      bounded: null,
      transformScale: 1,
      useCssTransforms: !0,
      useStyleCursor: !0,
      isDragging: !1,
      dragging: {
        top: -1,
        left: -1
      },
      isResizing: !1,
      resizing: {
        width: -1,
        height: -1
      },
      style: {},
      rtl: !1
    });
    let L = !1, X = !1, _ = NaN, q = NaN, j = NaN, $ = NaN, G = -1, K = -1, V = -1, J = -1, h = i.x, y = i.y, p = i.w, R = i.h;
    const W = be(), Q = we({
      i: Oe(i, "i"),
      state: e,
      wrapper: W,
      calcXY: E
    });
    function Z(t) {
      Ie(t);
    }
    function U() {
      de();
    }
    function ee(t) {
      S(i.isDraggable) && (e.draggable = t);
    }
    function te(t) {
      S(i.isResizable) && (e.resizable = t);
    }
    function ie(t) {
      S(i.isBounded) && (e.bounded = t);
    }
    function re(t) {
      e.transformScale = t;
    }
    function ae(t) {
      e.rowHeight = t;
    }
    function ne(t) {
      e.maxRows = t;
    }
    function oe() {
      e.rtl = He() === "rtl", de();
    }
    function se(t) {
      e.cols = Math.floor(t);
    }
    l.increaseItem(Q), Ae(() => {
      e.rtl = He() === "rtl";
    }), Pe(() => {
      l.responsive && l.lastBreakpoint ? e.cols = Ze(l.lastBreakpoint, l.cols) : e.cols = l.colNum, e.rowHeight = l.rowHeight, e.containerWidth = l.width !== null ? l.width : 100, e.margin = l.margin !== void 0 ? l.margin.map(Number) : [10, 10], e.maxRows = l.maxRows, S(i.isDraggable) ? e.draggable = l.isDraggable : e.draggable = i.isDraggable, S(i.isResizable) ? e.resizable = l.isResizable : e.resizable = i.isResizable, S(i.isBounded) ? e.bounded = l.isBounded : e.bounded = i.isBounded, e.transformScale = l.transformScale, e.useCssTransforms = l.useCssTransforms, e.useStyleCursor = l.useStyleCursor, Ye(() => {
        h = i.x, y = i.y, R = i.h, p = i.w, f(x);
      }), g.on("updateWidth", Z), g.on("compact", U), g.on("setDraggable", ee), g.on("setResizable", te), g.on("setBounded", ie), g.on("setTransformScale", re), g.on("setRowHeight", ae), g.on("setMaxRows", ne), g.on("directionchange", oe), g.on("setColNum", se);
    }), Le(() => {
      g.off("updateWidth", Z), g.off("compact", U), g.off("setDraggable", ee), g.off("setResizable", te), g.off("setBounded", ie), g.off("setTransformScale", re), g.off("setRowHeight", ae), g.off("setMaxRows", ne), g.off("directionchange", oe), g.off("setColNum", se), u.value && (u.value.unset(), u.value = null), l.decreaseItem(Q);
    }), Be({ state: e, wrapper: W });
    const Ne = navigator.userAgent.toLowerCase().includes("android"), le = D(() => e.resizable && !i.static), m = D(() => l.isMirrored ? !e.rtl : e.rtl), Ce = D(() => (e.draggable || e.resizable) && !i.static), z = Qe("item"), De = D(() => ({
      [z.b()]: !0,
      [z.bm("resizable")]: le.value,
      [z.bm("static")]: i.static,
      [z.bm("resizing")]: e.isResizing,
      [z.bm("dragging")]: e.isDragging,
      [z.bm("transform")]: e.useCssTransforms,
      [z.bm("rtl")]: m.value,
      [z.bm("no-touch")]: Ne && Ce.value
    })), I = D(() => [z.be("resizer"), m.value && z.bem("resizer", "rtl")].filter(Boolean));
    w(
      () => i.isDraggable,
      (t) => {
        e.draggable = t;
      }
    ), w(
      () => i.static,
      () => {
        f(he), f(H);
      }
    ), w(
      () => e.draggable,
      () => {
        f(he);
      }
    ), w(
      () => i.isResizable,
      (t) => {
        e.resizable = t;
      }
    ), w(
      () => i.isBounded,
      (t) => {
        e.bounded = t;
      }
    ), w(
      () => e.resizable,
      () => {
        f(H);
      }
    ), w(
      () => e.rowHeight,
      () => {
        f(x), f(k);
      }
    ), w([() => e.cols, () => e.containerWidth], () => {
      f(H), f(x), f(k);
    }), w([() => i.minH, () => i.maxH, () => i.minW, () => i.maxW], () => {
      f(H);
    }), w(m, () => {
      f(H), f(x);
    }), w([() => l.margin, () => l.margin[0], () => l.margin[1]], () => {
      const t = l.margin;
      !t || t[0] === e.margin[0] && t[1] === e.margin[1] || (e.margin = t.map(Number), f(x), f(k));
    });
    function x() {
      i.x + i.w > e.cols ? (h = 0, p = i.w > e.cols ? e.cols : i.w) : (h = i.x, p = i.w);
      const t = B(h, y, p, R);
      e.isDragging && (t.top = e.dragging.top, m.value ? t.right = e.dragging.left : t.left = e.dragging.left), e.isResizing && (t.width = e.resizing.width, t.height = e.resizing.height);
      let a;
      e.useCssTransforms ? m.value ? a = Ge(t.top, t.right, t.width, t.height) : a = Ke(t.top, t.left, t.width, t.height) : m.value ? a = Ve(t.top, t.right, t.width, t.height) : a = Je(t.top, t.left, t.width, t.height), e.style = a;
    }
    function k() {
      const t = {};
      for (const a of ["width", "height"]) {
        const o = e.style[a].match(/^(\d+)px$/);
        if (!o)
          return;
        t[a] = o[1];
      }
      M("container-resized", i.i, i.h, i.w, t.height, t.width);
    }
    function ge(t) {
      if (i.static)
        return;
      const a = t.type;
      if (a === "resizestart" && e.isResizing || a !== "resizestart" && !e.isResizing)
        return;
      const s = Se(t);
      if (S(s))
        return;
      const { x: o, y: c } = s, n = { width: 0, height: 0 };
      let r;
      switch (a) {
        case "resizestart": {
          H(), G = p, K = R, r = B(h, y, p, R), n.width = r.width, n.height = r.height, e.resizing = n, e.isResizing = !0;
          break;
        }
        case "resizemove": {
          const d = xe(j, $, o, c);
          m.value ? n.width = e.resizing.width - d.deltaX / e.transformScale : n.width = e.resizing.width + d.deltaX / e.transformScale, n.height = e.resizing.height + d.deltaY / e.transformScale, e.resizing = n;
          break;
        }
        case "resizeend": {
          r = B(h, y, p, R), n.width = r.width, n.height = r.height, e.resizing = { width: -1, height: -1 }, e.isResizing = !1;
          break;
        }
      }
      r = Te(n.height, n.width), r.w < i.minW && (r.w = i.minW), r.w > i.maxW && (r.w = i.maxW), r.h < i.minH && (r.h = i.minH), r.h > i.maxH && (r.h = i.maxH), r.h < 1 && (r.h = 1), r.w < 1 && (r.w = 1), j = o, $ = c, (p !== r.w || R !== r.h) && M("resize", i.i, r.h, r.w, n.height, n.width), t.type === "resizeend" && (G !== p || K !== R) && M("resized", i.i, r.h, r.w, n.height, n.width), g.emit("resizeEvent", t.type, i.i, h, y, r.h, r.w);
    }
    function ce(t) {
      if (i.static || e.isResizing)
        return;
      const a = t.type;
      if (a === "dragstart" && e.isDragging || a !== "dragstart" && !e.isDragging)
        return;
      const s = Se(t);
      if (S(s))
        return;
      const { x: o, y: c } = s, n = t.target;
      if (!n.offsetParent)
        return;
      const r = { top: 0, left: 0 };
      switch (a) {
        case "dragstart": {
          V = h, J = y;
          const b = n.offsetParent.getBoundingClientRect(), v = n.getBoundingClientRect(), N = v.left / e.transformScale, C = b.left / e.transformScale, F = v.right / e.transformScale, O = b.right / e.transformScale, A = v.top / e.transformScale, P = b.top / e.transformScale;
          m.value ? r.left = (F - O) * -1 : r.left = N - C, r.top = A - P, e.dragging = r, e.isDragging = !0;
          break;
        }
        case "dragmove": {
          const b = xe(_, q, o, c);
          if (m.value ? r.left = e.dragging.left - b.deltaX / e.transformScale : r.left = e.dragging.left + b.deltaX / e.transformScale, r.top = e.dragging.top + b.deltaY / e.transformScale, e.bounded) {
            const v = n.offsetParent.clientHeight - fe(i.h, e.rowHeight, e.margin[1]);
            r.top = ue(r.top, 0, v);
            const N = T(), C = e.containerWidth - fe(i.w, N, e.margin[0]);
            r.left = ue(r.left, 0, C);
          }
          e.dragging = r;
          break;
        }
        case "dragend": {
          const b = n.offsetParent.getBoundingClientRect(), v = n.getBoundingClientRect(), N = v.left / e.transformScale, C = b.left / e.transformScale, F = v.right / e.transformScale, O = b.right / e.transformScale, A = v.top / e.transformScale, P = b.top / e.transformScale;
          m.value ? r.left = (F - O) * -1 : r.left = N - C, r.top = A - P, e.dragging = { top: -1, left: -1 }, e.isDragging = !1;
          break;
        }
      }
      let d;
      m.value, d = E(r.top, r.left), _ = o, q = c, (h !== d.x || y !== d.y) && M("move", i.i, d.x, d.y), t.type === "dragend" && (V !== h || J !== y) && M("moved", i.i, d.x, d.y), g.emit("dragEvent", t.type, i.i, d.x, d.y, R, p);
    }
    function B(t, a, s, o) {
      const c = T();
      let n;
      return m.value ? n = {
        right: Math.round(c * t + (t + 1) * e.margin[0]),
        top: Math.round(e.rowHeight * a + (a + 1) * e.margin[1]),
        // 0 * Infinity === NaN, which causes problems with resize constraints;
        // Fix this if it occurs.
        // Note we do it here rather than later because Math.round(Infinity) causes depot
        width: s === 1 / 0 ? s : Math.round(c * s + Math.max(0, s - 1) * e.margin[0]),
        height: o === 1 / 0 ? o : Math.round(e.rowHeight * o + Math.max(0, o - 1) * e.margin[1])
      } : n = {
        left: Math.round(c * t + (t + 1) * e.margin[0]),
        top: Math.round(e.rowHeight * a + (a + 1) * e.margin[1]),
        // 0 * Infinity === NaN, which causes problems with resize constraints;
        // Fix this if it occurs.
        // Note we do it here rather than later because Math.round(Infinity) causes depot
        width: s === 1 / 0 ? s : Math.round(c * s + Math.max(0, s - 1) * e.margin[0]),
        height: o === 1 / 0 ? o : Math.round(e.rowHeight * o + Math.max(0, o - 1) * e.margin[1])
      }, n;
    }
    function E(t, a) {
      const s = T();
      let o = Math.round((a - e.margin[0]) / (s + e.margin[0])), c = Math.round((t - e.margin[1]) / (e.rowHeight + e.margin[1]));
      return o = Math.max(Math.min(o, e.cols - p), 0), c = Math.max(Math.min(c, e.maxRows - R), 0), { x: o, y: c };
    }
    function T() {
      return (e.containerWidth - e.margin[0] * (e.cols + 1)) / e.cols;
    }
    function fe(t, a, s) {
      return Number.isFinite(t) ? Math.round(a * t + Math.max(0, t - 1) * s) : t;
    }
    function ue(t, a, s) {
      return Math.max(Math.min(t, s), a);
    }
    function Te(t, a, s = !1) {
      const o = T();
      let c = Math.round((a + e.margin[0]) / (o + e.margin[0])), n = 0;
      return s ? n = Math.ceil((t + e.margin[1]) / (e.rowHeight + e.margin[1])) : n = Math.round((t + e.margin[1]) / (e.rowHeight + e.margin[1])), c = Math.max(Math.min(c, e.cols - h), 0), n = Math.max(Math.min(n, e.maxRows - y), 0), { w: c, h: n };
    }
    function Ie(t, a) {
      e.containerWidth = t, a != null && (e.cols = a);
    }
    function de() {
      x();
    }
    function me() {
      !u.value && W.value && (u.value = Me(W.value), e.useStyleCursor || u.value.styleCursor(!1));
    }
    const ke = ve(ce);
    function he() {
      if (me(), !!u.value)
        if (e.draggable && !i.static) {
          const t = {
            ignoreFrom: i.dragIgnoreFrom,
            allowFrom: i.dragAllowFrom,
            ...i.dragOption
          };
          u.value.draggable(t), L || (L = !0, u.value.on("dragstart dragmove dragend", (a) => {
            a.type === "dragmove" ? ke(a) : ce(a);
          }));
        } else
          u.value.draggable({ enabled: !1 });
    }
    const Ee = ve(ge);
    function H() {
      if (me(), !!u.value)
        if (e.resizable && !i.static) {
          const t = B(0, 0, i.maxW, i.maxH), a = B(0, 0, i.minW, i.minH), s = {
            edges: {
              left: !1,
              right: `.${I.value[0]}`,
              bottom: `.${I.value[0]}`,
              top: !1
            },
            ignoreFrom: i.resizeIgnoreFrom,
            restrictSize: {
              min: {
                height: a.height * e.transformScale,
                width: a.width * e.transformScale
              },
              max: {
                height: t.height * e.transformScale,
                width: t.width * e.transformScale
              }
            },
            ...i.resizeOption
          };
          i.preserveAspectRatio && (s.modifiers = [Me.modifiers.aspectRatio({ ratio: "preserve" })]), u.value.resizable(s), X || (X = !0, u.value.on("resizestart resizemove resizeend", (o) => {
            o.type === "resizemove" ? Ee(o) : ge(o);
          }));
        } else
          u.value.resizable({ enabled: !1 });
    }
    return (t, a) => (ze(), ye("section", {
      ref_key: "wrapper",
      ref: W,
      class: Re(Y(De)),
      style: Xe(e.style)
    }, [
      _e(t.$slots, "default"),
      Y(le) ? (ze(), ye("span", {
        key: 0,
        class: Re(Y(I))
      }, null, 2)) : qe("", !0)
    ], 6));
  }
});
export {
  ot as default
};
//# sourceMappingURL=grid-item.vue.mjs.map
