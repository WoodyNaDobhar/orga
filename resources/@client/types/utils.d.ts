type ExtractProps<T> = InstanceType<T>["$props"];

type DotPrefix<T extends string> = T extends "" ? "" : `.${T}`;

export {}
declare global {
  interface Window {
    DateTime: any 
  }
}

type DotNestedKeys<T> = (
  T extends object
    ? {
        [K in Exclude<keyof T, symbol>]: `${K}${DotPrefix<
          DotNestedKeys<T[K]>
        >}`;
      }[Exclude<keyof T, symbol>]
    : ""
) extends infer D
  ? Extract<D, string>
  : never;
