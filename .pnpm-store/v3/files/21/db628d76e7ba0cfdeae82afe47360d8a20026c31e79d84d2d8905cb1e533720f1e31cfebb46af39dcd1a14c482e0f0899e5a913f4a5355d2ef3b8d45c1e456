import { defineComponent as Q, reactive as D, ref as H, onBeforeMount as Z, onMounted as ee, nextTick as y, onBeforeUnmount as te, watch as s, provide as N, toRefs as O, openBlock as z, createElementBlock as _, normalizeStyle as ae, renderSlot as M, Fragment as oe, renderList as le, createBlock as ie, mergeProps as re, withCtx as ne, withDirectives as se, createVNode as ue, vShow as ce } from "vue";
import F from "./grid-item.vue.mjs";
import { useResize as de } from "@vexip-ui/hooks";
import { createEventEmitter as pe, debounce as fe, isNull as w } from "@vexip-ui/utils";
import { validateLayout as ye, compact as B, LAYOUT_KEY as ge, EMITTER_KEY as me, bottom as he, getLayoutItem as I, moveElement as ve, getAllCollisions as we, cloneLayout as Be } from "../helpers/common.mjs";
import { getBreakpointFromWidth as be, getColsFromBreakpoint as T, findOrGenerateResponsiveLayout as xe } from "../helpers/responsive.mjs";
const Se = /* @__PURE__ */ Q({
  __name: "grid-layout",
  props: {
    autoSize: {
      type: Boolean,
      default: !0
    },
    colNum: {
      type: Number,
      default: 12
    },
    rowHeight: {
      type: Number,
      default: 150
    },
    maxRows: {
      type: Number,
      default: 1 / 0
    },
    margin: {
      type: Array,
      default: () => [10, 10]
    },
    isDraggable: {
      type: Boolean,
      default: !0
    },
    isResizable: {
      type: Boolean,
      default: !0
    },
    isMirrored: {
      type: Boolean,
      default: !1
    },
    isBounded: {
      type: Boolean,
      default: !1
    },
    useCssTransforms: {
      type: Boolean,
      default: !0
    },
    verticalCompact: {
      type: Boolean,
      default: !0
    },
    restoreOnDrag: {
      type: Boolean,
      default: !1
    },
    layout: {
      type: Array,
      required: !0
    },
    responsive: {
      type: Boolean,
      default: !1
    },
    responsiveLayouts: {
      type: Object,
      default: () => ({})
    },
    transformScale: {
      type: Number,
      default: 1
    },
    breakpoints: {
      type: Object,
      default: () => ({ lg: 1200, md: 996, sm: 768, xs: 480, xxs: 0 })
    },
    cols: {
      type: Object,
      default: () => ({ lg: 12, md: 10, sm: 6, xs: 4, xxs: 2 })
    },
    preventCollision: {
      type: Boolean,
      default: !1
    },
    useStyleCursor: {
      type: Boolean,
      default: !0
    }
  },
  emits: [
    "layout-before-mount",
    "layout-mounted",
    "layout-updated",
    "breakpoint-changed",
    "update:layout",
    "layout-ready"
  ],
  setup(W, { expose: A, emit: u }) {
    const a = W, t = D({
      width: -1,
      mergedStyle: {},
      lastLayoutLength: 0,
      isDragging: !1,
      placeholder: {
        x: 0,
        y: 0,
        w: 0,
        h: 0,
        i: ""
      },
      layouts: {},
      // array to store all layouts from different breakpoints
      lastBreakpoint: null,
      // store last active breakpoint
      originalLayout: null
      // store original Layout
    }), L = /* @__PURE__ */ new Map(), l = H(a.layout), g = H(), { observeResize: Y, unobserveResize: j } = de(), r = pe();
    r.on("resizeEvent", $), r.on("dragEvent", q), Z(() => {
      u("layout-before-mount", l.value);
    }), ee(() => {
      u("layout-mounted", l.value), y(() => {
        ye(l.value), t.originalLayout = l.value, y(() => {
          S(), g.value && Y(g.value, fe(k, 16)), B(l.value, a.verticalCompact), u("layout-updated", l.value), m(), k();
        });
      });
    }), te(() => {
      r.clearAll(), g.value && j(g.value);
    });
    function $(e, n, i, p, c, d) {
      E(e, n, i, p, c, d);
    }
    function q(e, n, i, p, c, d) {
      R(e, n, i, p, c, d);
    }
    s(
      () => t.width,
      (e, n) => {
        y(() => {
          r.emit("updateWidth", e), n === -1 && y(() => {
            u("layout-ready", l.value);
          }), m();
        });
      }
    ), s(
      () => [a.layout, a.layout.length],
      () => {
        l.value = a.layout, P();
      }
    ), s(
      () => a.colNum,
      (e) => {
        r.emit("setColNum", e);
      }
    ), s(
      () => a.rowHeight,
      (e) => {
        r.emit("setRowHeight", e);
      }
    ), s(
      () => a.isDraggable,
      (e) => {
        r.emit("setDraggable", e);
      }
    ), s(
      () => a.isResizable,
      (e) => {
        r.emit("setResizable", e);
      }
    ), s(
      () => a.isBounded,
      (e) => {
        r.emit("setBounded", e);
      }
    ), s(
      () => a.transformScale,
      (e) => {
        r.emit("setTransformScale", e);
      }
    ), s(
      () => a.responsive,
      (e) => {
        e || (u("update:layout", t.originalLayout), r.emit("setColNum", a.colNum)), k();
      }
    ), s(
      () => a.maxRows,
      (e) => {
        r.emit("setMaxRows", e);
      }
    ), s([() => a.margin, () => a.margin[1]], m), N(
      ge,
      D({
        ...O(a),
        ...O(t),
        increaseItem: U,
        decreaseItem: G
      })
    ), N(me, r), A({ state: t, getItem: K, resizeEvent: E, dragEvent: R });
    function U(e) {
      L.set(e.i, e);
    }
    function G(e) {
      L.delete(e.i);
    }
    function K(e) {
      return L.get(e);
    }
    function P() {
      if (!w(l.value) && !w(t.originalLayout)) {
        if (l.value.length !== t.originalLayout.length) {
          const e = J(l.value, t.originalLayout);
          if (e.length > 0)
            if (l.value.length > t.originalLayout.length)
              t.originalLayout = t.originalLayout.concat(e);
            else {
              const n = new Set(e.map((i) => i.i));
              t.originalLayout = t.originalLayout.filter((i) => !n.has(i.i));
            }
          t.lastLayoutLength = l.value.length, S();
        }
        B(l.value, a.verticalCompact), r.emit("updateWidth", t.width), m(), u("layout-updated", l.value);
      }
    }
    function m() {
      t.mergedStyle = {
        height: V()
      };
    }
    function k() {
      g.value && (t.width = g.value.offsetWidth), r.emit("resizeEvent");
    }
    function V() {
      if (!a.autoSize)
        return;
      const e = parseFloat(a.margin[1]);
      return he(l.value) * (a.rowHeight + e) + e + "px";
    }
    let C;
    function R(e, n, i, p, c, d) {
      let o = I(l.value, n);
      w(o) && (o = { h: 0, w: 0, x: 0, y: 0, i: "" }), e === "dragstart" && !a.verticalCompact && (C = l.value.reduce(
        (v, { i: b, x: f, y: h }) => ({
          ...v,
          [b]: { x: f, y: h }
        }),
        {}
      )), e === "dragmove" || e === "dragstart" ? (t.placeholder.i = n, t.placeholder.x = o.x, t.placeholder.y = o.y, t.placeholder.w = d, t.placeholder.h = c, y(() => {
        t.isDragging = !0;
      }), r.emit("updateWidth", t.width)) : y(() => {
        t.isDragging = !1;
      }), l.value = ve(l.value, o, i, p, !0, a.preventCollision), a.restoreOnDrag ? (o.static = !0, B(l.value, a.verticalCompact, C), o.static = !1) : B(l.value, a.verticalCompact), r.emit("compact"), m(), e === "dragend" && (C = void 0, u("layout-updated", l.value));
    }
    function E(e, n, i, p, c, d) {
      let o = I(l.value, n);
      w(o) && (o = { h: 0, w: 0, x: 0, y: 0, i: "" });
      let v;
      if (a.preventCollision) {
        const b = we(l.value, { ...o, w: d, h: c }).filter(
          (f) => f.i !== o.i
        );
        if (v = b.length > 0, v) {
          let f = 1 / 0, h = 1 / 0;
          b.forEach((x) => {
            x.x > o.x && (f = Math.min(f, x.x)), x.y > o.y && (h = Math.min(h, x.y));
          }), Number.isFinite(f) && (o.w = f - o.x), Number.isFinite(h) && (o.h = h - o.y);
        }
      }
      v || (o.w = d, o.h = c), e === "resizestart" || e === "resizemove" ? (t.placeholder.i = n, t.placeholder.x = i, t.placeholder.y = p, t.placeholder.w = o.w, t.placeholder.h = o.h, y(() => {
        t.isDragging = !0;
      }), r.emit("updateWidth", t.width)) : y(() => {
        t.isDragging = !1;
      }), a.responsive && X(), B(l.value, a.verticalCompact), r.emit("compact"), m(), e === "resizeend" && u("layout-updated", l.value);
    }
    function X() {
      const e = be(a.breakpoints, t.width), n = T(e, a.cols);
      !w(t.lastBreakpoint) && !t.layouts[t.lastBreakpoint] && (t.layouts[t.lastBreakpoint] = Be(l.value));
      const i = xe(
        t.originalLayout,
        t.layouts,
        a.breakpoints,
        e,
        t.lastBreakpoint,
        n,
        a.verticalCompact
      );
      t.layouts[e] = i, t.lastBreakpoint !== e && u("breakpoint-changed", e, i), u("update:layout", i), t.lastBreakpoint = e, r.emit("setColNum", T(e, a.cols));
    }
    function S() {
      t.layouts = Object.assign({}, a.responsiveLayouts);
    }
    function J(e, n) {
      const i = new Set(n.map((o) => o.i)), p = new Set(e.map((o) => o.i)), c = e.filter((o) => !i.has(o.i)), d = n.filter((o) => !p.has(o.i));
      return c.concat(d);
    }
    return (e, n) => (z(), _("div", {
      ref_key: "wrapper",
      ref: g,
      class: "vgl-layout",
      style: ae(t.mergedStyle)
    }, [
      e.$slots.default ? M(e.$slots, "default", { key: 0 }) : (z(!0), _(oe, { key: 1 }, le(l.value, (i) => (z(), ie(F, re({
        key: i.i
      }, i), {
        default: ne(() => [
          M(e.$slots, "item", { item: i })
        ]),
        _: 2
      }, 1040))), 128)),
      se(ue(F, {
        class: "vgl-item--placeholder",
        x: t.placeholder.x,
        y: t.placeholder.y,
        w: t.placeholder.w,
        h: t.placeholder.h,
        i: t.placeholder.i
      }, null, 8, ["x", "y", "w", "h", "i"]), [
        [ce, t.isDragging]
      ])
    ], 4));
  }
});
export {
  Se as default
};
//# sourceMappingURL=grid-layout.vue.mjs.map
