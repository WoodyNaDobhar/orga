const T = Symbol("LAYOUT_KEY"), v = Symbol("EMITTER_KEY");
function A(r) {
  let n = 0, t;
  for (let e = 0, i = r.length; e < i; e++)
    t = r[e].y + r[e].h, t > n && (n = t);
  return n;
}
function Y(r) {
  const n = Array(r.length);
  for (let t = 0, e = r.length; t < e; t++)
    n[t] = y(r[t]);
  return n;
}
function y(r) {
  return { ...r };
}
function d(r, n) {
  return !(r === n || r.x + r.w <= n.x || r.x >= n.x + n.w || r.y + r.h <= n.y || r.y >= n.y + n.h);
}
function $(r, n, t) {
  const e = b(r), i = g(r), o = Array(r.length);
  for (let s = 0, f = i.length; s < f; s++) {
    let c = i[s];
    c.static || (c = E(e, c, n, t), e.push(c)), o[r.indexOf(c)] = c, c.moved = !1;
  }
  return o;
}
function E(r, n, t, e) {
  if (t)
    for (; n.y > 0 && !l(r, n); )
      n.y--;
  else if (e) {
    const o = e[n.i].y;
    for (; n.y > o && !l(r, n); )
      n.y--;
  }
  let i;
  for (; i = l(r, n); )
    n.y = i.y + i.h;
  return n;
}
function _(r, n) {
  const t = b(r);
  for (let e = 0, i = r.length; e < i; e++) {
    const o = r[e];
    if (o.x + o.w > n.cols && (o.x = n.cols - o.w), o.x < 0 && (o.x = 0, o.w = n.cols), !o.static)
      t.push(o);
    else
      for (; l(t, o); )
        o.y++;
  }
  return r;
}
function C(r, n) {
  for (let t = 0, e = r.length; t < e; t++)
    if (r[t].i === n)
      return r[t];
}
function l(r, n) {
  for (let t = 0, e = r.length; t < e; t++)
    if (d(r[t], n))
      return r[t];
}
function L(r, n) {
  return r.filter((t) => d(t, n));
}
function b(r) {
  return r.filter((n) => n.static);
}
function x(r, n, t, e, i = !1, o = !1) {
  if (n.static)
    return r;
  const s = n.x, f = n.y, c = e && n.y > e;
  typeof t == "number" && (n.x = t), typeof e == "number" && (n.y = e), n.moved = !0;
  let h = g(r);
  c && (h = h.reverse());
  const p = L(h, n);
  if (o && p.length)
    return n.x = s, n.y = f, n.moved = !1, r;
  for (let w = 0, m = p.length; w < m; w++) {
    const u = p[w];
    u.moved || n.y > u.y && n.y - u.y > u.h / 4 || (u.static ? r = a(r, u, n, i) : r = a(r, n, u, i));
  }
  return r;
}
function a(r, n, t, e) {
  if (e) {
    const o = {
      x: t.x,
      y: t.y,
      w: t.w,
      h: t.h,
      i: "-1"
    };
    if (o.y = Math.max(n.y - t.h, 0), !l(r, o))
      return x(r, t, void 0, o.y, !1);
  }
  return x(r, t, void 0, t.y + 1, !1);
}
function O(r, n, t, e) {
  const i = "translate3d(" + n + "px," + r + "px, 0)";
  return {
    transform: i,
    WebkitTransform: i,
    MozTransform: i,
    msTransform: i,
    OTransform: i,
    width: t + "px",
    height: e + "px",
    position: "absolute"
  };
}
function G(r, n, t, e) {
  const i = "translate3d(" + n * -1 + "px," + r + "px, 0)";
  return {
    transform: i,
    WebkitTransform: i,
    MozTransform: i,
    msTransform: i,
    OTransform: i,
    width: t + "px",
    height: e + "px",
    position: "absolute"
  };
}
function R(r, n, t, e) {
  return {
    top: r + "px",
    left: n + "px",
    width: t + "px",
    height: e + "px",
    position: "absolute"
  };
}
function V(r, n, t, e) {
  return {
    top: r + "px",
    right: n + "px",
    width: t + "px",
    height: e + "px",
    position: "absolute"
  };
}
function g(r) {
  return Array.from(r).sort(function(n, t) {
    return n.y === t.y && n.x === t.x ? 0 : n.y > t.y || n.y === t.y && n.x > t.x ? 1 : -1;
  });
}
function k(r, n) {
  n = n || "Layout";
  const t = ["x", "y", "w", "h"], e = [];
  if (!Array.isArray(r))
    throw new Error(n + " must be an array!");
  for (let i = 0, o = r.length; i < o; i++) {
    const s = r[i];
    for (let f = 0; f < t.length; f++)
      if (typeof s[t[f]] != "number")
        throw new Error(
          "VueGridLayout: " + n + "[" + i + "]." + t[f] + " must be a number!"
        );
    if (s.i === void 0 || s.i === null)
      throw new Error("VueGridLayout: " + n + "[" + i + "].i cannot be null!");
    if (typeof s.i != "number" && typeof s.i != "string")
      throw new Error("VueGridLayout: " + n + "[" + i + "].i must be a string or number!");
    if (e.indexOf(s.i) >= 0)
      throw new Error("VueGridLayout: " + n + "[" + i + "].i must be unique!");
    if (e.push(s.i), s.static !== void 0 && typeof s.static != "boolean")
      throw new Error("VueGridLayout: " + n + "[" + i + "].static must be a boolean!");
  }
}
function K(r, n = "vgl") {
  const t = () => `${n}-${r}`;
  return {
    b: t,
    be: (s) => `${t()}__${s}`,
    bm: (s) => `${t()}--${s}`,
    bem: (s, f) => `${t()}__${s}--${f}`
  };
}
export {
  v as EMITTER_KEY,
  T as LAYOUT_KEY,
  A as bottom,
  Y as cloneLayout,
  y as cloneLayoutItem,
  d as collides,
  $ as compact,
  E as compactItem,
  _ as correctBounds,
  L as getAllCollisions,
  l as getFirstCollision,
  C as getLayoutItem,
  b as getStatics,
  x as moveElement,
  a as moveElementAwayFromCollision,
  R as setTopLeft,
  V as setTopRight,
  O as setTransform,
  G as setTransformRtl,
  g as sortLayoutItemsByRowCol,
  K as useNameHelper,
  k as validateLayout
};
//# sourceMappingURL=common.mjs.map
