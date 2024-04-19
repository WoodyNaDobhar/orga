<!DOCTYPE html>
<html lang="en" class="theme-4"><head>
	<meta charset="UTF-8">
	<link href="/favicon.ico" rel="icon">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ORK4</title>
	<script type="text/javascript" async="" src="https://www.gstatic.com/recaptcha/releases/QoukH5jSO3sKFzVEA7Vc8VgC/recaptcha__en.js" crossorigin="anonymous" integrity="sha384-A236J/ZUgU+0/O6b/VC6BQicPcdW8QQ1ITyp6reToIynSHMur3SvFRIaG/Cbkgq+"></script>
	<script src="https://www.google.com/recaptcha/api.js?render=6Ld0uKkpAAAAAEhsp2RIPuXAzZiGlivQIFw2_TuB&amp;hl=en" async="" defer=""></script>
	<style type="text/css" data-vite-dev-id="/home/woody/orga/node_modules/vue-loading-overlay/dist/css/index.css">
		.vl-shown {
		  overflow: hidden;
		}
		
		.vl-overlay {
		  bottom: 0;
		  left: 0;
		  position: absolute;
		  right: 0;
		  top: 0;
		  align-items: center;
		  display: none;
		  justify-content: center;
		  overflow: hidden;
		  z-index: 9999;
		}
		
		.vl-overlay.vl-active {
		  display: flex;
		}
		
		.vl-overlay.vl-full-page {
		  z-index: 9999;
		  position: fixed;
		}
		
		.vl-overlay .vl-background {
		  bottom: 0;
		  left: 0;
		  position: absolute;
		  right: 0;
		  top: 0;
		  background: #fff;
		  opacity: 0.5;
		}
		
		.vl-overlay .vl-icon, .vl-parent {
		  position: relative;
		}
	</style>
	<style type="text/css" data-vite-dev-id="/home/woody/orga/resources/@client/assets/css/app.css">/*
		 |--------------------------------------------------------------------------
		 | Fonts
		 |--------------------------------------------------------------------------
		 |
		 | Import all fonts used in the template, the font configuration can be
		 | seen in "tailwind.config.js".
		 |
		 | Please check this link for more details:
		 | https://tailwindcss.com/docs/theme
		 |
		 */
		/* cyrillic-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 100;
		    font-display: swap;
		    src: local("Roboto Thin Italic"), local("Roboto-ThinItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOiCnqEu92Fr1Mu51QrEz0dL-vwnYh2eg.woff2)
		            format("woff2");
		    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F,
		        U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 100;
		    font-display: swap;
		    src: local("Roboto Thin Italic"), local("Roboto-ThinItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOiCnqEu92Fr1Mu51QrEzQdL-vwnYh2eg.woff2)
		            format("woff2");
		    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* greek-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 100;
		    font-display: swap;
		    src: local("Roboto Thin Italic"), local("Roboto-ThinItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOiCnqEu92Fr1Mu51QrEzwdL-vwnYh2eg.woff2)
		            format("woff2");
		    unicode-range: U+1F00-1FFF;
		}
		/* greek */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 100;
		    font-display: swap;
		    src: local("Roboto Thin Italic"), local("Roboto-ThinItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOiCnqEu92Fr1Mu51QrEzMdL-vwnYh2eg.woff2)
		            format("woff2");
		    unicode-range: U+0370-03FF;
		}
		/* vietnamese */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 100;
		    font-display: swap;
		    src: local("Roboto Thin Italic"), local("Roboto-ThinItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOiCnqEu92Fr1Mu51QrEz8dL-vwnYh2eg.woff2)
		            format("woff2");
		    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 100;
		    font-display: swap;
		    src: local("Roboto Thin Italic"), local("Roboto-ThinItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOiCnqEu92Fr1Mu51QrEz4dL-vwnYh2eg.woff2)
		            format("woff2");
		    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB,
		        U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 100;
		    font-display: swap;
		    src: local("Roboto Thin Italic"), local("Roboto-ThinItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOiCnqEu92Fr1Mu51QrEzAdL-vwnYg.woff2)
		            format("woff2");
		    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA,
		        U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212,
		        U+2215, U+FEFF, U+FFFD;
		}
		/* cyrillic-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 300;
		    font-display: swap;
		    src: local("Roboto Light Italic"), local("Roboto-LightItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TjASc3CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F,
		        U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 300;
		    font-display: swap;
		    src: local("Roboto Light Italic"), local("Roboto-LightItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TjASc-CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* greek-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 300;
		    font-display: swap;
		    src: local("Roboto Light Italic"), local("Roboto-LightItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TjASc2CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+1F00-1FFF;
		}
		/* greek */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 300;
		    font-display: swap;
		    src: local("Roboto Light Italic"), local("Roboto-LightItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TjASc5CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0370-03FF;
		}
		/* vietnamese */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 300;
		    font-display: swap;
		    src: local("Roboto Light Italic"), local("Roboto-LightItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TjASc1CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 300;
		    font-display: swap;
		    src: local("Roboto Light Italic"), local("Roboto-LightItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TjASc0CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB,
		        U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 300;
		    font-display: swap;
		    src: local("Roboto Light Italic"), local("Roboto-LightItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TjASc6CsTYl4BO.woff2)
		            format("woff2");
		    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA,
		        U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212,
		        U+2215, U+FEFF, U+FFFD;
		}
		/* cyrillic-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 400;
		    font-display: swap;
		    src: local("Roboto Italic"), local("Roboto-Italic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOkCnqEu92Fr1Mu51xFIzIXKMnyrYk.woff2)
		            format("woff2");
		    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F,
		        U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 400;
		    font-display: swap;
		    src: local("Roboto Italic"), local("Roboto-Italic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOkCnqEu92Fr1Mu51xMIzIXKMnyrYk.woff2)
		            format("woff2");
		    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* greek-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 400;
		    font-display: swap;
		    src: local("Roboto Italic"), local("Roboto-Italic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOkCnqEu92Fr1Mu51xEIzIXKMnyrYk.woff2)
		            format("woff2");
		    unicode-range: U+1F00-1FFF;
		}
		/* greek */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 400;
		    font-display: swap;
		    src: local("Roboto Italic"), local("Roboto-Italic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOkCnqEu92Fr1Mu51xLIzIXKMnyrYk.woff2)
		            format("woff2");
		    unicode-range: U+0370-03FF;
		}
		/* vietnamese */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 400;
		    font-display: swap;
		    src: local("Roboto Italic"), local("Roboto-Italic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOkCnqEu92Fr1Mu51xHIzIXKMnyrYk.woff2)
		            format("woff2");
		    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 400;
		    font-display: swap;
		    src: local("Roboto Italic"), local("Roboto-Italic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOkCnqEu92Fr1Mu51xGIzIXKMnyrYk.woff2)
		            format("woff2");
		    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB,
		        U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 400;
		    font-display: swap;
		    src: local("Roboto Italic"), local("Roboto-Italic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOkCnqEu92Fr1Mu51xIIzIXKMny.woff2)
		            format("woff2");
		    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA,
		        U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212,
		        U+2215, U+FEFF, U+FFFD;
		}
		/* cyrillic-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 500;
		    font-display: swap;
		    src: local("Roboto Medium Italic"), local("Roboto-MediumItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51S7ACc3CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F,
		        U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 500;
		    font-display: swap;
		    src: local("Roboto Medium Italic"), local("Roboto-MediumItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51S7ACc-CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* greek-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 500;
		    font-display: swap;
		    src: local("Roboto Medium Italic"), local("Roboto-MediumItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51S7ACc2CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+1F00-1FFF;
		}
		/* greek */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 500;
		    font-display: swap;
		    src: local("Roboto Medium Italic"), local("Roboto-MediumItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51S7ACc5CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0370-03FF;
		}
		/* vietnamese */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 500;
		    font-display: swap;
		    src: local("Roboto Medium Italic"), local("Roboto-MediumItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51S7ACc1CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 500;
		    font-display: swap;
		    src: local("Roboto Medium Italic"), local("Roboto-MediumItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51S7ACc0CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB,
		        U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 500;
		    font-display: swap;
		    src: local("Roboto Medium Italic"), local("Roboto-MediumItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51S7ACc6CsTYl4BO.woff2)
		            format("woff2");
		    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA,
		        U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212,
		        U+2215, U+FEFF, U+FFFD;
		}
		/* cyrillic-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 700;
		    font-display: swap;
		    src: local("Roboto Bold Italic"), local("Roboto-BoldItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TzBic3CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F,
		        U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 700;
		    font-display: swap;
		    src: local("Roboto Bold Italic"), local("Roboto-BoldItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TzBic-CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* greek-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 700;
		    font-display: swap;
		    src: local("Roboto Bold Italic"), local("Roboto-BoldItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TzBic2CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+1F00-1FFF;
		}
		/* greek */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 700;
		    font-display: swap;
		    src: local("Roboto Bold Italic"), local("Roboto-BoldItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TzBic5CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0370-03FF;
		}
		/* vietnamese */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 700;
		    font-display: swap;
		    src: local("Roboto Bold Italic"), local("Roboto-BoldItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TzBic1CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 700;
		    font-display: swap;
		    src: local("Roboto Bold Italic"), local("Roboto-BoldItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TzBic0CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB,
		        U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 700;
		    font-display: swap;
		    src: local("Roboto Bold Italic"), local("Roboto-BoldItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TzBic6CsTYl4BO.woff2)
		            format("woff2");
		    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA,
		        U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212,
		        U+2215, U+FEFF, U+FFFD;
		}
		/* cyrillic-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 900;
		    font-display: swap;
		    src: local("Roboto Black Italic"), local("Roboto-BlackItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TLBCc3CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F,
		        U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 900;
		    font-display: swap;
		    src: local("Roboto Black Italic"), local("Roboto-BlackItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TLBCc-CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* greek-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 900;
		    font-display: swap;
		    src: local("Roboto Black Italic"), local("Roboto-BlackItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TLBCc2CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+1F00-1FFF;
		}
		/* greek */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 900;
		    font-display: swap;
		    src: local("Roboto Black Italic"), local("Roboto-BlackItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TLBCc5CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0370-03FF;
		}
		/* vietnamese */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 900;
		    font-display: swap;
		    src: local("Roboto Black Italic"), local("Roboto-BlackItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TLBCc1CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 900;
		    font-display: swap;
		    src: local("Roboto Black Italic"), local("Roboto-BlackItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TLBCc0CsTYl4BOQ3o.woff2)
		            format("woff2");
		    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB,
		        U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		    font-family: "Roboto";
		    font-style: italic;
		    font-weight: 900;
		    font-display: swap;
		    src: local("Roboto Black Italic"), local("Roboto-BlackItalic"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOjCnqEu92Fr1Mu51TLBCc6CsTYl4BO.woff2)
		            format("woff2");
		    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA,
		        U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212,
		        U+2215, U+FEFF, U+FFFD;
		}
		/* cyrillic-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 100;
		    font-display: swap;
		    src: local("Roboto Thin"), local("Roboto-Thin"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOkCnqEu92Fr1MmgVxFIzIXKMnyrYk.woff2)
		            format("woff2");
		    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F,
		        U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 100;
		    font-display: swap;
		    src: local("Roboto Thin"), local("Roboto-Thin"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOkCnqEu92Fr1MmgVxMIzIXKMnyrYk.woff2)
		            format("woff2");
		    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* greek-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 100;
		    font-display: swap;
		    src: local("Roboto Thin"), local("Roboto-Thin"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOkCnqEu92Fr1MmgVxEIzIXKMnyrYk.woff2)
		            format("woff2");
		    unicode-range: U+1F00-1FFF;
		}
		/* greek */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 100;
		    font-display: swap;
		    src: local("Roboto Thin"), local("Roboto-Thin"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOkCnqEu92Fr1MmgVxLIzIXKMnyrYk.woff2)
		            format("woff2");
		    unicode-range: U+0370-03FF;
		}
		/* vietnamese */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 100;
		    font-display: swap;
		    src: local("Roboto Thin"), local("Roboto-Thin"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOkCnqEu92Fr1MmgVxHIzIXKMnyrYk.woff2)
		            format("woff2");
		    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 100;
		    font-display: swap;
		    src: local("Roboto Thin"), local("Roboto-Thin"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOkCnqEu92Fr1MmgVxGIzIXKMnyrYk.woff2)
		            format("woff2");
		    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB,
		        U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 100;
		    font-display: swap;
		    src: local("Roboto Thin"), local("Roboto-Thin"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOkCnqEu92Fr1MmgVxIIzIXKMny.woff2)
		            format("woff2");
		    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA,
		        U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212,
		        U+2215, U+FEFF, U+FFFD;
		}
		/* cyrillic-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 300;
		    font-display: swap;
		    src: local("Roboto Light"), local("Roboto-Light"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmSU5fCRc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F,
		        U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 300;
		    font-display: swap;
		    src: local("Roboto Light"), local("Roboto-Light"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmSU5fABc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* greek-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 300;
		    font-display: swap;
		    src: local("Roboto Light"), local("Roboto-Light"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmSU5fCBc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+1F00-1FFF;
		}
		/* greek */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 300;
		    font-display: swap;
		    src: local("Roboto Light"), local("Roboto-Light"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmSU5fBxc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0370-03FF;
		}
		/* vietnamese */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 300;
		    font-display: swap;
		    src: local("Roboto Light"), local("Roboto-Light"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmSU5fCxc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 300;
		    font-display: swap;
		    src: local("Roboto Light"), local("Roboto-Light"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmSU5fChc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB,
		        U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 300;
		    font-display: swap;
		    src: local("Roboto Light"), local("Roboto-Light"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmSU5fBBc4AMP6lQ.woff2)
		            format("woff2");
		    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA,
		        U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212,
		        U+2215, U+FEFF, U+FFFD;
		}
		/* cyrillic-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 400;
		    font-display: swap;
		    src: local("Roboto"), local("Roboto-Regular"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOmCnqEu92Fr1Mu72xKKTU1Kvnz.woff2)
		            format("woff2");
		    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F,
		        U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 400;
		    font-display: swap;
		    src: local("Roboto"), local("Roboto-Regular"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOmCnqEu92Fr1Mu5mxKKTU1Kvnz.woff2)
		            format("woff2");
		    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* greek-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 400;
		    font-display: swap;
		    src: local("Roboto"), local("Roboto-Regular"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOmCnqEu92Fr1Mu7mxKKTU1Kvnz.woff2)
		            format("woff2");
		    unicode-range: U+1F00-1FFF;
		}
		/* greek */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 400;
		    font-display: swap;
		    src: local("Roboto"), local("Roboto-Regular"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOmCnqEu92Fr1Mu4WxKKTU1Kvnz.woff2)
		            format("woff2");
		    unicode-range: U+0370-03FF;
		}
		/* vietnamese */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 400;
		    font-display: swap;
		    src: local("Roboto"), local("Roboto-Regular"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOmCnqEu92Fr1Mu7WxKKTU1Kvnz.woff2)
		            format("woff2");
		    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 400;
		    font-display: swap;
		    src: local("Roboto"), local("Roboto-Regular"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOmCnqEu92Fr1Mu7GxKKTU1Kvnz.woff2)
		            format("woff2");
		    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB,
		        U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 400;
		    font-display: swap;
		    src: local("Roboto"), local("Roboto-Regular"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOmCnqEu92Fr1Mu4mxKKTU1Kg.woff2)
		            format("woff2");
		    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA,
		        U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212,
		        U+2215, U+FEFF, U+FFFD;
		}
		/* cyrillic-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 500;
		    font-display: swap;
		    src: local("Roboto Medium"), local("Roboto-Medium"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmEU9fCRc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F,
		        U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 500;
		    font-display: swap;
		    src: local("Roboto Medium"), local("Roboto-Medium"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmEU9fABc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* greek-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 500;
		    font-display: swap;
		    src: local("Roboto Medium"), local("Roboto-Medium"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmEU9fCBc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+1F00-1FFF;
		}
		/* greek */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 500;
		    font-display: swap;
		    src: local("Roboto Medium"), local("Roboto-Medium"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmEU9fBxc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0370-03FF;
		}
		/* vietnamese */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 500;
		    font-display: swap;
		    src: local("Roboto Medium"), local("Roboto-Medium"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmEU9fCxc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 500;
		    font-display: swap;
		    src: local("Roboto Medium"), local("Roboto-Medium"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmEU9fChc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB,
		        U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 500;
		    font-display: swap;
		    src: local("Roboto Medium"), local("Roboto-Medium"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmEU9fBBc4AMP6lQ.woff2)
		            format("woff2");
		    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA,
		        U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212,
		        U+2215, U+FEFF, U+FFFD;
		}
		/* cyrillic-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 700;
		    font-display: swap;
		    src: local("Roboto Bold"), local("Roboto-Bold"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmWUlfCRc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F,
		        U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 700;
		    font-display: swap;
		    src: local("Roboto Bold"), local("Roboto-Bold"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmWUlfABc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* greek-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 700;
		    font-display: swap;
		    src: local("Roboto Bold"), local("Roboto-Bold"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmWUlfCBc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+1F00-1FFF;
		}
		/* greek */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 700;
		    font-display: swap;
		    src: local("Roboto Bold"), local("Roboto-Bold"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmWUlfBxc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0370-03FF;
		}
		/* vietnamese */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 700;
		    font-display: swap;
		    src: local("Roboto Bold"), local("Roboto-Bold"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmWUlfCxc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 700;
		    font-display: swap;
		    src: local("Roboto Bold"), local("Roboto-Bold"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmWUlfChc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB,
		        U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 700;
		    font-display: swap;
		    src: local("Roboto Bold"), local("Roboto-Bold"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmWUlfBBc4AMP6lQ.woff2)
		            format("woff2");
		    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA,
		        U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212,
		        U+2215, U+FEFF, U+FFFD;
		}
		/* cyrillic-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 900;
		    font-display: swap;
		    src: local("Roboto Black"), local("Roboto-Black"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmYUtfCRc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F,
		        U+FE2E-FE2F;
		}
		/* cyrillic */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 900;
		    font-display: swap;
		    src: local("Roboto Black"), local("Roboto-Black"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmYUtfABc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
		}
		/* greek-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 900;
		    font-display: swap;
		    src: local("Roboto Black"), local("Roboto-Black"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmYUtfCBc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+1F00-1FFF;
		}
		/* greek */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 900;
		    font-display: swap;
		    src: local("Roboto Black"), local("Roboto-Black"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmYUtfBxc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0370-03FF;
		}
		/* vietnamese */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 900;
		    font-display: swap;
		    src: local("Roboto Black"), local("Roboto-Black"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmYUtfCxc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
		}
		/* latin-ext */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 900;
		    font-display: swap;
		    src: local("Roboto Black"), local("Roboto-Black"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmYUtfChc4AMP6lbBP.woff2)
		            format("woff2");
		    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB,
		        U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
		}
		/* latin */
		@font-face {
		    font-family: "Roboto";
		    font-style: normal;
		    font-weight: 900;
		    font-display: swap;
		    src: local("Roboto Black"), local("Roboto-Black"),
		        url(https://fonts.gstatic.com/s/roboto/v20/KFOlCnqEu92Fr1MmYUtfBBc4AMP6lQ.woff2)
		            format("woff2");
		    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA,
		        U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212,
		        U+2215, U+FEFF, U+FFFD;
		}
		/*
		 |--------------------------------------------------------------------------
		 | Components
		 |--------------------------------------------------------------------------
		 |
		 | Import CSS components.
		 |
		 */
		html.dark body {
		            color: #cbd5e1;
		        }
		html.dark body *,
		            html.dark body ::before,
		            html.dark body ::after {
		                border-color: rgb(255 255 255 / 5%);
		            }
		html body {
		        letter-spacing: 0.025em;
		        font-size: 0.875rem;
		        -webkit-font-smoothing: antialiased;
		        -moz-osx-font-smoothing: grayscale;
		        font-family: Roboto;
		        color: #475569;
		        line-height: 1.25rem;
		    }
		* > .intro-x:nth-child(1) {
		            z-index: calc(50 - 1);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(1 * 0.1s);
		        }
		* > .-intro-x:nth-child(1) {
		            z-index: calc(50 - 1);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(1 * 0.1s);
		        }
		* > .intro-y:nth-child(1) {
		            z-index: calc(50 - 1);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(1 * 0.1s);
		        }
		* > .-intro-y:nth-child(1) {
		            z-index: calc(50 - 1);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(1 * 0.1s);
		        }
		* > .intro-x:nth-child(2) {
		            z-index: calc(50 - 2);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(2 * 0.1s);
		        }
		* > .-intro-x:nth-child(2) {
		            z-index: calc(50 - 2);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(2 * 0.1s);
		        }
		* > .intro-y:nth-child(2) {
		            z-index: calc(50 - 2);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(2 * 0.1s);
		        }
		* > .-intro-y:nth-child(2) {
		            z-index: calc(50 - 2);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(2 * 0.1s);
		        }
		* > .intro-x:nth-child(3) {
		            z-index: calc(50 - 3);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(3 * 0.1s);
		        }
		* > .-intro-x:nth-child(3) {
		            z-index: calc(50 - 3);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(3 * 0.1s);
		        }
		* > .intro-y:nth-child(3) {
		            z-index: calc(50 - 3);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(3 * 0.1s);
		        }
		* > .-intro-y:nth-child(3) {
		            z-index: calc(50 - 3);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(3 * 0.1s);
		        }
		* > .intro-x:nth-child(4) {
		            z-index: calc(50 - 4);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(4 * 0.1s);
		        }
		* > .-intro-x:nth-child(4) {
		            z-index: calc(50 - 4);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(4 * 0.1s);
		        }
		* > .intro-y:nth-child(4) {
		            z-index: calc(50 - 4);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(4 * 0.1s);
		        }
		* > .-intro-y:nth-child(4) {
		            z-index: calc(50 - 4);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(4 * 0.1s);
		        }
		* > .intro-x:nth-child(5) {
		            z-index: calc(50 - 5);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(5 * 0.1s);
		        }
		* > .-intro-x:nth-child(5) {
		            z-index: calc(50 - 5);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(5 * 0.1s);
		        }
		* > .intro-y:nth-child(5) {
		            z-index: calc(50 - 5);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(5 * 0.1s);
		        }
		* > .-intro-y:nth-child(5) {
		            z-index: calc(50 - 5);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(5 * 0.1s);
		        }
		* > .intro-x:nth-child(6) {
		            z-index: calc(50 - 6);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(6 * 0.1s);
		        }
		* > .-intro-x:nth-child(6) {
		            z-index: calc(50 - 6);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(6 * 0.1s);
		        }
		* > .intro-y:nth-child(6) {
		            z-index: calc(50 - 6);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(6 * 0.1s);
		        }
		* > .-intro-y:nth-child(6) {
		            z-index: calc(50 - 6);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(6 * 0.1s);
		        }
		* > .intro-x:nth-child(7) {
		            z-index: calc(50 - 7);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(7 * 0.1s);
		        }
		* > .-intro-x:nth-child(7) {
		            z-index: calc(50 - 7);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(7 * 0.1s);
		        }
		* > .intro-y:nth-child(7) {
		            z-index: calc(50 - 7);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(7 * 0.1s);
		        }
		* > .-intro-y:nth-child(7) {
		            z-index: calc(50 - 7);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(7 * 0.1s);
		        }
		* > .intro-x:nth-child(8) {
		            z-index: calc(50 - 8);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(8 * 0.1s);
		        }
		* > .-intro-x:nth-child(8) {
		            z-index: calc(50 - 8);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(8 * 0.1s);
		        }
		* > .intro-y:nth-child(8) {
		            z-index: calc(50 - 8);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(8 * 0.1s);
		        }
		* > .-intro-y:nth-child(8) {
		            z-index: calc(50 - 8);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(8 * 0.1s);
		        }
		* > .intro-x:nth-child(9) {
		            z-index: calc(50 - 9);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(9 * 0.1s);
		        }
		* > .-intro-x:nth-child(9) {
		            z-index: calc(50 - 9);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(9 * 0.1s);
		        }
		* > .intro-y:nth-child(9) {
		            z-index: calc(50 - 9);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(9 * 0.1s);
		        }
		* > .-intro-y:nth-child(9) {
		            z-index: calc(50 - 9);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(9 * 0.1s);
		        }
		* > .intro-x:nth-child(10) {
		            z-index: calc(50 - 10);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(10 * 0.1s);
		        }
		* > .-intro-x:nth-child(10) {
		            z-index: calc(50 - 10);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(10 * 0.1s);
		        }
		* > .intro-y:nth-child(10) {
		            z-index: calc(50 - 10);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(10 * 0.1s);
		        }
		* > .-intro-y:nth-child(10) {
		            z-index: calc(50 - 10);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(10 * 0.1s);
		        }
		* > .intro-x:nth-child(11) {
		            z-index: calc(50 - 11);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(11 * 0.1s);
		        }
		* > .-intro-x:nth-child(11) {
		            z-index: calc(50 - 11);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(11 * 0.1s);
		        }
		* > .intro-y:nth-child(11) {
		            z-index: calc(50 - 11);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(11 * 0.1s);
		        }
		* > .-intro-y:nth-child(11) {
		            z-index: calc(50 - 11);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(11 * 0.1s);
		        }
		* > .intro-x:nth-child(12) {
		            z-index: calc(50 - 12);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(12 * 0.1s);
		        }
		* > .-intro-x:nth-child(12) {
		            z-index: calc(50 - 12);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(12 * 0.1s);
		        }
		* > .intro-y:nth-child(12) {
		            z-index: calc(50 - 12);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(12 * 0.1s);
		        }
		* > .-intro-y:nth-child(12) {
		            z-index: calc(50 - 12);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(12 * 0.1s);
		        }
		* > .intro-x:nth-child(13) {
		            z-index: calc(50 - 13);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(13 * 0.1s);
		        }
		* > .-intro-x:nth-child(13) {
		            z-index: calc(50 - 13);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(13 * 0.1s);
		        }
		* > .intro-y:nth-child(13) {
		            z-index: calc(50 - 13);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(13 * 0.1s);
		        }
		* > .-intro-y:nth-child(13) {
		            z-index: calc(50 - 13);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(13 * 0.1s);
		        }
		* > .intro-x:nth-child(14) {
		            z-index: calc(50 - 14);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(14 * 0.1s);
		        }
		* > .-intro-x:nth-child(14) {
		            z-index: calc(50 - 14);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(14 * 0.1s);
		        }
		* > .intro-y:nth-child(14) {
		            z-index: calc(50 - 14);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(14 * 0.1s);
		        }
		* > .-intro-y:nth-child(14) {
		            z-index: calc(50 - 14);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(14 * 0.1s);
		        }
		* > .intro-x:nth-child(15) {
		            z-index: calc(50 - 15);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(15 * 0.1s);
		        }
		* > .-intro-x:nth-child(15) {
		            z-index: calc(50 - 15);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(15 * 0.1s);
		        }
		* > .intro-y:nth-child(15) {
		            z-index: calc(50 - 15);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(15 * 0.1s);
		        }
		* > .-intro-y:nth-child(15) {
		            z-index: calc(50 - 15);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(15 * 0.1s);
		        }
		* > .intro-x:nth-child(16) {
		            z-index: calc(50 - 16);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(16 * 0.1s);
		        }
		* > .-intro-x:nth-child(16) {
		            z-index: calc(50 - 16);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(16 * 0.1s);
		        }
		* > .intro-y:nth-child(16) {
		            z-index: calc(50 - 16);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(16 * 0.1s);
		        }
		* > .-intro-y:nth-child(16) {
		            z-index: calc(50 - 16);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(16 * 0.1s);
		        }
		* > .intro-x:nth-child(17) {
		            z-index: calc(50 - 17);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(17 * 0.1s);
		        }
		* > .-intro-x:nth-child(17) {
		            z-index: calc(50 - 17);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(17 * 0.1s);
		        }
		* > .intro-y:nth-child(17) {
		            z-index: calc(50 - 17);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(17 * 0.1s);
		        }
		* > .-intro-y:nth-child(17) {
		            z-index: calc(50 - 17);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(17 * 0.1s);
		        }
		* > .intro-x:nth-child(18) {
		            z-index: calc(50 - 18);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(18 * 0.1s);
		        }
		* > .-intro-x:nth-child(18) {
		            z-index: calc(50 - 18);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(18 * 0.1s);
		        }
		* > .intro-y:nth-child(18) {
		            z-index: calc(50 - 18);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(18 * 0.1s);
		        }
		* > .-intro-y:nth-child(18) {
		            z-index: calc(50 - 18);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(18 * 0.1s);
		        }
		* > .intro-x:nth-child(19) {
		            z-index: calc(50 - 19);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(19 * 0.1s);
		        }
		* > .-intro-x:nth-child(19) {
		            z-index: calc(50 - 19);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(19 * 0.1s);
		        }
		* > .intro-y:nth-child(19) {
		            z-index: calc(50 - 19);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(19 * 0.1s);
		        }
		* > .-intro-y:nth-child(19) {
		            z-index: calc(50 - 19);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(19 * 0.1s);
		        }
		* > .intro-x:nth-child(20) {
		            z-index: calc(50 - 20);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(20 * 0.1s);
		        }
		* > .-intro-x:nth-child(20) {
		            z-index: calc(50 - 20);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(20 * 0.1s);
		        }
		* > .intro-y:nth-child(20) {
		            z-index: calc(50 - 20);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(20 * 0.1s);
		        }
		* > .-intro-y:nth-child(20) {
		            z-index: calc(50 - 20);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(20 * 0.1s);
		        }
		* > .intro-x:nth-child(21) {
		            z-index: calc(50 - 21);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(21 * 0.1s);
		        }
		* > .-intro-x:nth-child(21) {
		            z-index: calc(50 - 21);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(21 * 0.1s);
		        }
		* > .intro-y:nth-child(21) {
		            z-index: calc(50 - 21);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(21 * 0.1s);
		        }
		* > .-intro-y:nth-child(21) {
		            z-index: calc(50 - 21);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(21 * 0.1s);
		        }
		* > .intro-x:nth-child(22) {
		            z-index: calc(50 - 22);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(22 * 0.1s);
		        }
		* > .-intro-x:nth-child(22) {
		            z-index: calc(50 - 22);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(22 * 0.1s);
		        }
		* > .intro-y:nth-child(22) {
		            z-index: calc(50 - 22);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(22 * 0.1s);
		        }
		* > .-intro-y:nth-child(22) {
		            z-index: calc(50 - 22);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(22 * 0.1s);
		        }
		* > .intro-x:nth-child(23) {
		            z-index: calc(50 - 23);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(23 * 0.1s);
		        }
		* > .-intro-x:nth-child(23) {
		            z-index: calc(50 - 23);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(23 * 0.1s);
		        }
		* > .intro-y:nth-child(23) {
		            z-index: calc(50 - 23);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(23 * 0.1s);
		        }
		* > .-intro-y:nth-child(23) {
		            z-index: calc(50 - 23);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(23 * 0.1s);
		        }
		* > .intro-x:nth-child(24) {
		            z-index: calc(50 - 24);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(24 * 0.1s);
		        }
		* > .-intro-x:nth-child(24) {
		            z-index: calc(50 - 24);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(24 * 0.1s);
		        }
		* > .intro-y:nth-child(24) {
		            z-index: calc(50 - 24);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(24 * 0.1s);
		        }
		* > .-intro-y:nth-child(24) {
		            z-index: calc(50 - 24);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(24 * 0.1s);
		        }
		* > .intro-x:nth-child(25) {
		            z-index: calc(50 - 25);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(25 * 0.1s);
		        }
		* > .-intro-x:nth-child(25) {
		            z-index: calc(50 - 25);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(25 * 0.1s);
		        }
		* > .intro-y:nth-child(25) {
		            z-index: calc(50 - 25);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(25 * 0.1s);
		        }
		* > .-intro-y:nth-child(25) {
		            z-index: calc(50 - 25);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(25 * 0.1s);
		        }
		* > .intro-x:nth-child(26) {
		            z-index: calc(50 - 26);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(26 * 0.1s);
		        }
		* > .-intro-x:nth-child(26) {
		            z-index: calc(50 - 26);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(26 * 0.1s);
		        }
		* > .intro-y:nth-child(26) {
		            z-index: calc(50 - 26);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(26 * 0.1s);
		        }
		* > .-intro-y:nth-child(26) {
		            z-index: calc(50 - 26);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(26 * 0.1s);
		        }
		* > .intro-x:nth-child(27) {
		            z-index: calc(50 - 27);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(27 * 0.1s);
		        }
		* > .-intro-x:nth-child(27) {
		            z-index: calc(50 - 27);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(27 * 0.1s);
		        }
		* > .intro-y:nth-child(27) {
		            z-index: calc(50 - 27);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(27 * 0.1s);
		        }
		* > .-intro-y:nth-child(27) {
		            z-index: calc(50 - 27);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(27 * 0.1s);
		        }
		* > .intro-x:nth-child(28) {
		            z-index: calc(50 - 28);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(28 * 0.1s);
		        }
		* > .-intro-x:nth-child(28) {
		            z-index: calc(50 - 28);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(28 * 0.1s);
		        }
		* > .intro-y:nth-child(28) {
		            z-index: calc(50 - 28);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(28 * 0.1s);
		        }
		* > .-intro-y:nth-child(28) {
		            z-index: calc(50 - 28);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(28 * 0.1s);
		        }
		* > .intro-x:nth-child(29) {
		            z-index: calc(50 - 29);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(29 * 0.1s);
		        }
		* > .-intro-x:nth-child(29) {
		            z-index: calc(50 - 29);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(29 * 0.1s);
		        }
		* > .intro-y:nth-child(29) {
		            z-index: calc(50 - 29);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(29 * 0.1s);
		        }
		* > .-intro-y:nth-child(29) {
		            z-index: calc(50 - 29);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(29 * 0.1s);
		        }
		* > .intro-x:nth-child(30) {
		            z-index: calc(50 - 30);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(30 * 0.1s);
		        }
		* > .-intro-x:nth-child(30) {
		            z-index: calc(50 - 30);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(30 * 0.1s);
		        }
		* > .intro-y:nth-child(30) {
		            z-index: calc(50 - 30);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(30 * 0.1s);
		        }
		* > .-intro-y:nth-child(30) {
		            z-index: calc(50 - 30);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(30 * 0.1s);
		        }
		* > .intro-x:nth-child(31) {
		            z-index: calc(50 - 31);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(31 * 0.1s);
		        }
		* > .-intro-x:nth-child(31) {
		            z-index: calc(50 - 31);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(31 * 0.1s);
		        }
		* > .intro-y:nth-child(31) {
		            z-index: calc(50 - 31);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(31 * 0.1s);
		        }
		* > .-intro-y:nth-child(31) {
		            z-index: calc(50 - 31);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(31 * 0.1s);
		        }
		* > .intro-x:nth-child(32) {
		            z-index: calc(50 - 32);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(32 * 0.1s);
		        }
		* > .-intro-x:nth-child(32) {
		            z-index: calc(50 - 32);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(32 * 0.1s);
		        }
		* > .intro-y:nth-child(32) {
		            z-index: calc(50 - 32);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(32 * 0.1s);
		        }
		* > .-intro-y:nth-child(32) {
		            z-index: calc(50 - 32);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(32 * 0.1s);
		        }
		* > .intro-x:nth-child(33) {
		            z-index: calc(50 - 33);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(33 * 0.1s);
		        }
		* > .-intro-x:nth-child(33) {
		            z-index: calc(50 - 33);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(33 * 0.1s);
		        }
		* > .intro-y:nth-child(33) {
		            z-index: calc(50 - 33);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(33 * 0.1s);
		        }
		* > .-intro-y:nth-child(33) {
		            z-index: calc(50 - 33);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(33 * 0.1s);
		        }
		* > .intro-x:nth-child(34) {
		            z-index: calc(50 - 34);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(34 * 0.1s);
		        }
		* > .-intro-x:nth-child(34) {
		            z-index: calc(50 - 34);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(34 * 0.1s);
		        }
		* > .intro-y:nth-child(34) {
		            z-index: calc(50 - 34);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(34 * 0.1s);
		        }
		* > .-intro-y:nth-child(34) {
		            z-index: calc(50 - 34);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(34 * 0.1s);
		        }
		* > .intro-x:nth-child(35) {
		            z-index: calc(50 - 35);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(35 * 0.1s);
		        }
		* > .-intro-x:nth-child(35) {
		            z-index: calc(50 - 35);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(35 * 0.1s);
		        }
		* > .intro-y:nth-child(35) {
		            z-index: calc(50 - 35);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(35 * 0.1s);
		        }
		* > .-intro-y:nth-child(35) {
		            z-index: calc(50 - 35);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(35 * 0.1s);
		        }
		* > .intro-x:nth-child(36) {
		            z-index: calc(50 - 36);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(36 * 0.1s);
		        }
		* > .-intro-x:nth-child(36) {
		            z-index: calc(50 - 36);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(36 * 0.1s);
		        }
		* > .intro-y:nth-child(36) {
		            z-index: calc(50 - 36);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(36 * 0.1s);
		        }
		* > .-intro-y:nth-child(36) {
		            z-index: calc(50 - 36);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(36 * 0.1s);
		        }
		* > .intro-x:nth-child(37) {
		            z-index: calc(50 - 37);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(37 * 0.1s);
		        }
		* > .-intro-x:nth-child(37) {
		            z-index: calc(50 - 37);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(37 * 0.1s);
		        }
		* > .intro-y:nth-child(37) {
		            z-index: calc(50 - 37);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(37 * 0.1s);
		        }
		* > .-intro-y:nth-child(37) {
		            z-index: calc(50 - 37);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(37 * 0.1s);
		        }
		* > .intro-x:nth-child(38) {
		            z-index: calc(50 - 38);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(38 * 0.1s);
		        }
		* > .-intro-x:nth-child(38) {
		            z-index: calc(50 - 38);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(38 * 0.1s);
		        }
		* > .intro-y:nth-child(38) {
		            z-index: calc(50 - 38);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(38 * 0.1s);
		        }
		* > .-intro-y:nth-child(38) {
		            z-index: calc(50 - 38);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(38 * 0.1s);
		        }
		* > .intro-x:nth-child(39) {
		            z-index: calc(50 - 39);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(39 * 0.1s);
		        }
		* > .-intro-x:nth-child(39) {
		            z-index: calc(50 - 39);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(39 * 0.1s);
		        }
		* > .intro-y:nth-child(39) {
		            z-index: calc(50 - 39);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(39 * 0.1s);
		        }
		* > .-intro-y:nth-child(39) {
		            z-index: calc(50 - 39);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(39 * 0.1s);
		        }
		* > .intro-x:nth-child(40) {
		            z-index: calc(50 - 40);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(40 * 0.1s);
		        }
		* > .-intro-x:nth-child(40) {
		            z-index: calc(50 - 40);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(40 * 0.1s);
		        }
		* > .intro-y:nth-child(40) {
		            z-index: calc(50 - 40);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(40 * 0.1s);
		        }
		* > .-intro-y:nth-child(40) {
		            z-index: calc(50 - 40);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(40 * 0.1s);
		        }
		* > .intro-x:nth-child(41) {
		            z-index: calc(50 - 41);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(41 * 0.1s);
		        }
		* > .-intro-x:nth-child(41) {
		            z-index: calc(50 - 41);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(41 * 0.1s);
		        }
		* > .intro-y:nth-child(41) {
		            z-index: calc(50 - 41);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(41 * 0.1s);
		        }
		* > .-intro-y:nth-child(41) {
		            z-index: calc(50 - 41);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(41 * 0.1s);
		        }
		* > .intro-x:nth-child(42) {
		            z-index: calc(50 - 42);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(42 * 0.1s);
		        }
		* > .-intro-x:nth-child(42) {
		            z-index: calc(50 - 42);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(42 * 0.1s);
		        }
		* > .intro-y:nth-child(42) {
		            z-index: calc(50 - 42);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(42 * 0.1s);
		        }
		* > .-intro-y:nth-child(42) {
		            z-index: calc(50 - 42);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(42 * 0.1s);
		        }
		* > .intro-x:nth-child(43) {
		            z-index: calc(50 - 43);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(43 * 0.1s);
		        }
		* > .-intro-x:nth-child(43) {
		            z-index: calc(50 - 43);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(43 * 0.1s);
		        }
		* > .intro-y:nth-child(43) {
		            z-index: calc(50 - 43);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(43 * 0.1s);
		        }
		* > .-intro-y:nth-child(43) {
		            z-index: calc(50 - 43);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(43 * 0.1s);
		        }
		* > .intro-x:nth-child(44) {
		            z-index: calc(50 - 44);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(44 * 0.1s);
		        }
		* > .-intro-x:nth-child(44) {
		            z-index: calc(50 - 44);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(44 * 0.1s);
		        }
		* > .intro-y:nth-child(44) {
		            z-index: calc(50 - 44);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(44 * 0.1s);
		        }
		* > .-intro-y:nth-child(44) {
		            z-index: calc(50 - 44);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(44 * 0.1s);
		        }
		* > .intro-x:nth-child(45) {
		            z-index: calc(50 - 45);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(45 * 0.1s);
		        }
		* > .-intro-x:nth-child(45) {
		            z-index: calc(50 - 45);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(45 * 0.1s);
		        }
		* > .intro-y:nth-child(45) {
		            z-index: calc(50 - 45);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(45 * 0.1s);
		        }
		* > .-intro-y:nth-child(45) {
		            z-index: calc(50 - 45);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(45 * 0.1s);
		        }
		* > .intro-x:nth-child(46) {
		            z-index: calc(50 - 46);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(46 * 0.1s);
		        }
		* > .-intro-x:nth-child(46) {
		            z-index: calc(50 - 46);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(46 * 0.1s);
		        }
		* > .intro-y:nth-child(46) {
		            z-index: calc(50 - 46);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(46 * 0.1s);
		        }
		* > .-intro-y:nth-child(46) {
		            z-index: calc(50 - 46);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(46 * 0.1s);
		        }
		* > .intro-x:nth-child(47) {
		            z-index: calc(50 - 47);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(47 * 0.1s);
		        }
		* > .-intro-x:nth-child(47) {
		            z-index: calc(50 - 47);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(47 * 0.1s);
		        }
		* > .intro-y:nth-child(47) {
		            z-index: calc(50 - 47);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(47 * 0.1s);
		        }
		* > .-intro-y:nth-child(47) {
		            z-index: calc(50 - 47);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(47 * 0.1s);
		        }
		* > .intro-x:nth-child(48) {
		            z-index: calc(50 - 48);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(48 * 0.1s);
		        }
		* > .-intro-x:nth-child(48) {
		            z-index: calc(50 - 48);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(48 * 0.1s);
		        }
		* > .intro-y:nth-child(48) {
		            z-index: calc(50 - 48);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(48 * 0.1s);
		        }
		* > .-intro-y:nth-child(48) {
		            z-index: calc(50 - 48);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(48 * 0.1s);
		        }
		* > .intro-x:nth-child(49) {
		            z-index: calc(50 - 49);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(49 * 0.1s);
		        }
		* > .-intro-x:nth-child(49) {
		            z-index: calc(50 - 49);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(49 * 0.1s);
		        }
		* > .intro-y:nth-child(49) {
		            z-index: calc(50 - 49);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(49 * 0.1s);
		        }
		* > .-intro-y:nth-child(49) {
		            z-index: calc(50 - 49);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(49 * 0.1s);
		        }
		* > .intro-x:nth-child(50) {
		            z-index: calc(50 - 50);
		            opacity: 0;
		            position: relative;
		            transform: translateX(50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(50 * 0.1s);
		        }
		* > .-intro-x:nth-child(50) {
		            z-index: calc(50 - 50);
		            opacity: 0;
		            position: relative;
		            transform: translateX(-50px);
		            animation: 0.4s intro-x-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(50 * 0.1s);
		        }
		* > .intro-y:nth-child(50) {
		            z-index: calc(50 - 50);
		            opacity: 0;
		            position: relative;
		            transform: translateY(50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(50 * 0.1s);
		        }
		* > .-intro-y:nth-child(50) {
		            z-index: calc(50 - 50);
		            opacity: 0;
		            position: relative;
		            transform: translateY(-50px);
		            animation: 0.4s intro-y-animation ease-in-out 0.33333s;
		            animation-fill-mode: forwards;
		            animation-delay: calc(50 * 0.1s);
		        }
		@keyframes intro-x-animation {
		    100% {
		        opacity: 1;
		        transform: translateX(0px);
		    }
		}
		@keyframes intro-y-animation {
		    100% {
		        opacity: 1;
		        transform: translateY(0px);
		    }
		}
		/*
		 |--------------------------------------------------------------------------
		 | TailwindCSS Directives
		 |--------------------------------------------------------------------------
		 |
		 | Import TailwindCSS directives and swipe out at build-time with all of
		 | the styles it generates based on your configured design system.
		 |
		 | Please check this link for more details:
		 | https://tailwindcss.com/docs/installation#include-tailwind-in-your-css
		 |
		 */
		/*
		 ! tailwindcss v3.4.1 | MIT License | https://tailwindcss.com
		 */
		/*
		1. Prevent padding and border from affecting element width. (https://github.com/mozdevs/cssremedy/issues/4)
		2. Allow adding a border to an element by just adding a border-width. (https://github.com/tailwindcss/tailwindcss/pull/116)
		*/
		*,
		::before,
		::after {
		  box-sizing: border-box; /* 1 */
		  border-width: 0; /* 2 */
		  border-style: solid; /* 2 */
		  border-color: #e5e7eb; /* 2 */
		}
		::before,
		::after {
		  --tw-content: '';
		}
		/*
		1. Use a consistent sensible line-height in all browsers.
		2. Prevent adjustments of font size after orientation changes in iOS.
		3. Use a more readable tab size.
		4. Use the user's configured `sans` font-family by default.
		5. Use the user's configured `sans` font-feature-settings by default.
		6. Use the user's configured `sans` font-variation-settings by default.
		7. Disable tap highlights on iOS
		*/
		html,
		:host {
		  line-height: 1.5; /* 1 */
		  -webkit-text-size-adjust: 100%; /* 2 */
		  -moz-tab-size: 4; /* 3 */
		  -o-tab-size: 4;
		     tab-size: 4; /* 3 */
		  font-family: ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"; /* 4 */
		  font-feature-settings: normal; /* 5 */
		  font-variation-settings: normal; /* 6 */
		  -webkit-tap-highlight-color: transparent; /* 7 */
		}
		/*
		1. Remove the margin in all browsers.
		2. Inherit line-height from `html` so users can set them as a class directly on the `html` element.
		*/
		body {
		  margin: 0; /* 1 */
		  line-height: inherit; /* 2 */
		}
		/*
		1. Add the correct height in Firefox.
		2. Correct the inheritance of border color in Firefox. (https://bugzilla.mozilla.org/show_bug.cgi?id=190655)
		3. Ensure horizontal rules are visible by default.
		*/
		hr {
		  height: 0; /* 1 */
		  color: inherit; /* 2 */
		  border-top-width: 1px; /* 3 */
		}
		/*
		Add the correct text decoration in Chrome, Edge, and Safari.
		*/
		abbr:where([title]) {
		  -webkit-text-decoration: underline dotted;
		          text-decoration: underline dotted;
		}
		/*
		Remove the default font size and weight for headings.
		*/
		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
		  font-size: inherit;
		  font-weight: inherit;
		}
		/*
		Reset links to optimize for opt-in styling instead of opt-out.
		*/
		a {
		  color: inherit;
		  text-decoration: inherit;
		}
		/*
		Add the correct font weight in Edge and Safari.
		*/
		b,
		strong {
		  font-weight: bolder;
		}
		/*
		1. Use the user's configured `mono` font-family by default.
		2. Use the user's configured `mono` font-feature-settings by default.
		3. Use the user's configured `mono` font-variation-settings by default.
		4. Correct the odd `em` font sizing in all browsers.
		*/
		code,
		kbd,
		samp,
		pre {
		  font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; /* 1 */
		  font-feature-settings: normal; /* 2 */
		  font-variation-settings: normal; /* 3 */
		  font-size: 1em; /* 4 */
		}
		/*
		Add the correct font size in all browsers.
		*/
		small {
		  font-size: 80%;
		}
		/*
		Prevent `sub` and `sup` elements from affecting the line height in all browsers.
		*/
		sub,
		sup {
		  font-size: 75%;
		  line-height: 0;
		  position: relative;
		  vertical-align: baseline;
		}
		sub {
		  bottom: -0.25em;
		}
		sup {
		  top: -0.5em;
		}
		/*
		1. Remove text indentation from table contents in Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=999088, https://bugs.webkit.org/show_bug.cgi?id=201297)
		2. Correct table border color inheritance in all Chrome and Safari. (https://bugs.chromium.org/p/chromium/issues/detail?id=935729, https://bugs.webkit.org/show_bug.cgi?id=195016)
		3. Remove gaps between table borders by default.
		*/
		table {
		  text-indent: 0; /* 1 */
		  border-color: inherit; /* 2 */
		  border-collapse: collapse; /* 3 */
		}
		/*
		1. Change the font styles in all browsers.
		2. Remove the margin in Firefox and Safari.
		3. Remove default padding in all browsers.
		*/
		button,
		input,
		optgroup,
		select,
		textarea {
		  font-family: inherit; /* 1 */
		  font-feature-settings: inherit; /* 1 */
		  font-variation-settings: inherit; /* 1 */
		  font-size: 100%; /* 1 */
		  font-weight: inherit; /* 1 */
		  line-height: inherit; /* 1 */
		  color: inherit; /* 1 */
		  margin: 0; /* 2 */
		  padding: 0; /* 3 */
		}
		/*
		Remove the inheritance of text transform in Edge and Firefox.
		*/
		button,
		select {
		  text-transform: none;
		}
		/*
		1. Correct the inability to style clickable types in iOS and Safari.
		2. Remove default button styles.
		*/
		button,
		[type='button'],
		[type='reset'],
		[type='submit'] {
		  -webkit-appearance: button; /* 1 */
		  background-color: transparent; /* 2 */
		  background-image: none; /* 2 */
		}
		/*
		Use the modern Firefox focus style for all focusable elements.
		*/
		:-moz-focusring {
		  outline: auto;
		}
		/*
		Remove the additional `:invalid` styles in Firefox. (https://github.com/mozilla/gecko-dev/blob/2f9eacd9d3d995c937b4251a5557d95d494c9be1/layout/style/res/forms.css#L728-L737)
		*/
		:-moz-ui-invalid {
		  box-shadow: none;
		}
		/*
		Add the correct vertical alignment in Chrome and Firefox.
		*/
		progress {
		  vertical-align: baseline;
		}
		/*
		Correct the cursor style of increment and decrement buttons in Safari.
		*/
		::-webkit-inner-spin-button,
		::-webkit-outer-spin-button {
		  height: auto;
		}
		/*
		1. Correct the odd appearance in Chrome and Safari.
		2. Correct the outline style in Safari.
		*/
		[type='search'] {
		  -webkit-appearance: textfield; /* 1 */
		  outline-offset: -2px; /* 2 */
		}
		/*
		Remove the inner padding in Chrome and Safari on macOS.
		*/
		::-webkit-search-decoration {
		  -webkit-appearance: none;
		}
		/*
		1. Correct the inability to style clickable types in iOS and Safari.
		2. Change font properties to `inherit` in Safari.
		*/
		::-webkit-file-upload-button {
		  -webkit-appearance: button; /* 1 */
		  font: inherit; /* 2 */
		}
		/*
		Add the correct display in Chrome and Safari.
		*/
		summary {
		  display: list-item;
		}
		/*
		Removes the default spacing and border for appropriate elements.
		*/
		blockquote,
		dl,
		dd,
		h1,
		h2,
		h3,
		h4,
		h5,
		h6,
		hr,
		figure,
		p,
		pre {
		  margin: 0;
		}
		fieldset {
		  margin: 0;
		  padding: 0;
		}
		legend {
		  padding: 0;
		}
		ol,
		ul,
		menu {
		  list-style: none;
		  margin: 0;
		  padding: 0;
		}
		/*
		Reset default styling for dialogs.
		*/
		dialog {
		  padding: 0;
		}
		/*
		Prevent resizing textareas horizontally by default.
		*/
		textarea {
		  resize: vertical;
		}
		/*
		1. Reset the default placeholder opacity in Firefox. (https://github.com/tailwindlabs/tailwindcss/issues/3300)
		2. Set the default placeholder color to the user's configured gray 400 color.
		*/
		input::-moz-placeholder, textarea::-moz-placeholder {
		  opacity: 1; /* 1 */
		  color: #9ca3af; /* 2 */
		}
		input::placeholder,
		textarea::placeholder {
		  opacity: 1; /* 1 */
		  color: #9ca3af; /* 2 */
		}
		/*
		Set the default cursor for buttons.
		*/
		button,
		[role="button"] {
		  cursor: pointer;
		}
		/*
		Make sure disabled buttons don't get the pointer cursor.
		*/
		:disabled {
		  cursor: default;
		}
		/*
		1. Make replaced elements `display: block` by default. (https://github.com/mozdevs/cssremedy/issues/14)
		2. Add `vertical-align: middle` to align replaced elements more sensibly by default. (https://github.com/jensimmons/cssremedy/issues/14#issuecomment-634934210)
		   This can trigger a poorly considered lint error in some tools but is included by design.
		*/
		img,
		svg,
		video,
		canvas,
		audio,
		iframe,
		embed,
		object {
		  display: block; /* 1 */
		  vertical-align: middle; /* 2 */
		}
		/*
		Constrain images and videos to the parent width and preserve their intrinsic aspect ratio. (https://github.com/mozdevs/cssremedy/issues/14)
		*/
		img,
		video {
		  max-width: 100%;
		  height: auto;
		}
		/* Make elements with the HTML hidden attribute stay hidden by default */
		[hidden] {
		  display: none;
		}
		[type='text'],input:where(:not([type])),[type='email'],[type='url'],[type='password'],[type='number'],[type='date'],[type='datetime-local'],[type='month'],[type='search'],[type='tel'],[type='time'],[type='week'],[multiple],textarea,select {
		    -webkit-appearance: none;
		       -moz-appearance: none;
		            appearance: none;
		    background-color: #fff;
		    border-color: #6b7280;
		    border-width: 1px;
		    border-radius: 0px;
		    padding-top: 0.5rem;
		    padding-right: 0.75rem;
		    padding-bottom: 0.5rem;
		    padding-left: 0.75rem;
		    font-size: 1rem;
		    line-height: 1.5rem;
		    --tw-shadow: 0 0 #0000;
		}
		[type='text']:focus, input:where(:not([type])):focus, [type='email']:focus, [type='url']:focus, [type='password']:focus, [type='number']:focus, [type='date']:focus, [type='datetime-local']:focus, [type='month']:focus, [type='search']:focus, [type='tel']:focus, [type='time']:focus, [type='week']:focus, [multiple]:focus, textarea:focus, select:focus {
		    outline: 2px solid transparent;
		    outline-offset: 2px;
		    --tw-ring-inset: var(--tw-empty,/*!*/ /*!*/);
		    --tw-ring-offset-width: 0px;
		    --tw-ring-offset-color: #fff;
		    --tw-ring-color: #2563eb;
		    --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
		    --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(1px + var(--tw-ring-offset-width)) var(--tw-ring-color);
		    box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow);
		    border-color: #2563eb;
		}
		input::-moz-placeholder, textarea::-moz-placeholder {
		    color: #6b7280;
		    opacity: 1;
		}
		input::placeholder,textarea::placeholder {
		    color: #6b7280;
		    opacity: 1;
		}
		::-webkit-datetime-edit-fields-wrapper {
		    padding: 0;
		}
		::-webkit-date-and-time-value {
		    min-height: 1.5em;
		    text-align: inherit;
		}
		::-webkit-datetime-edit {
		    display: inline-flex;
		}
		::-webkit-datetime-edit,::-webkit-datetime-edit-year-field,::-webkit-datetime-edit-month-field,::-webkit-datetime-edit-day-field,::-webkit-datetime-edit-hour-field,::-webkit-datetime-edit-minute-field,::-webkit-datetime-edit-second-field,::-webkit-datetime-edit-millisecond-field,::-webkit-datetime-edit-meridiem-field {
		    padding-top: 0;
		    padding-bottom: 0;
		}
		select {
		    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
		    background-position: right 0.5rem center;
		    background-repeat: no-repeat;
		    background-size: 1.5em 1.5em;
		    padding-right: 2.5rem;
		    -webkit-print-color-adjust: exact;
		            print-color-adjust: exact;
		}
		[multiple],[size]:where(select:not([size="1"])) {
		    background-image: initial;
		    background-position: initial;
		    background-repeat: unset;
		    background-size: initial;
		    padding-right: 0.75rem;
		    -webkit-print-color-adjust: unset;
		            print-color-adjust: unset;
		}
		[type='checkbox'],[type='radio'] {
		    -webkit-appearance: none;
		       -moz-appearance: none;
		            appearance: none;
		    padding: 0;
		    -webkit-print-color-adjust: exact;
		            print-color-adjust: exact;
		    display: inline-block;
		    vertical-align: middle;
		    background-origin: border-box;
		    -webkit-user-select: none;
		       -moz-user-select: none;
		            user-select: none;
		    flex-shrink: 0;
		    height: 1rem;
		    width: 1rem;
		    color: #2563eb;
		    background-color: #fff;
		    border-color: #6b7280;
		    border-width: 1px;
		    --tw-shadow: 0 0 #0000;
		}
		[type='checkbox'] {
		    border-radius: 0px;
		}
		[type='radio'] {
		    border-radius: 100%;
		}
		[type='checkbox']:focus,[type='radio']:focus {
		    outline: 2px solid transparent;
		    outline-offset: 2px;
		    --tw-ring-inset: var(--tw-empty,/*!*/ /*!*/);
		    --tw-ring-offset-width: 2px;
		    --tw-ring-offset-color: #fff;
		    --tw-ring-color: #2563eb;
		    --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
		    --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
		    box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow);
		}
		[type='checkbox']:checked,[type='radio']:checked {
		    border-color: transparent;
		    background-color: currentColor;
		    background-size: 100% 100%;
		    background-position: center;
		    background-repeat: no-repeat;
		}
		[type='checkbox']:checked {
		    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
		}
		@media (forced-colors: active)  {
		    [type='checkbox']:checked {
		        -webkit-appearance: auto;
		           -moz-appearance: auto;
		                appearance: auto;
		    }
		}
		[type='radio']:checked {
		    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3ccircle cx='8' cy='8' r='3'/%3e%3c/svg%3e");
		}
		@media (forced-colors: active)  {
		    [type='radio']:checked {
		        -webkit-appearance: auto;
		           -moz-appearance: auto;
		                appearance: auto;
		    }
		}
		[type='checkbox']:checked:hover,[type='checkbox']:checked:focus,[type='radio']:checked:hover,[type='radio']:checked:focus {
		    border-color: transparent;
		    background-color: currentColor;
		}
		[type='checkbox']:indeterminate {
		    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 16 16'%3e%3cpath stroke='white' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 8h8'/%3e%3c/svg%3e");
		    border-color: transparent;
		    background-color: currentColor;
		    background-size: 100% 100%;
		    background-position: center;
		    background-repeat: no-repeat;
		}
		@media (forced-colors: active)  {
		    [type='checkbox']:indeterminate {
		        -webkit-appearance: auto;
		           -moz-appearance: auto;
		                appearance: auto;
		    }
		}
		[type='checkbox']:indeterminate:hover,[type='checkbox']:indeterminate:focus {
		    border-color: transparent;
		    background-color: currentColor;
		}
		[type='file'] {
		    background: unset;
		    border-color: inherit;
		    border-width: 0;
		    border-radius: 0;
		    padding: 0;
		    font-size: unset;
		    line-height: inherit;
		}
		[type='file']:focus {
		    outline: 1px solid ButtonText;
		    outline: 1px auto -webkit-focus-ring-color;
		}
		:root {
		    --color-theme-1: 30 64 175;
		    --color-theme-2: 30 58 138;
		    --color-primary: 30 58 138;
		    --color-secondary: 226 232 240;
		    --color-success: 132 204 22;
		    --color-info: 6 182 212;
		    --color-warning: 250 204 21;
		    --color-pending: 249 115 22;
		    --color-danger: 220 38 38;
		    --color-light: 241 245 249;
		    --color-dark: 30 41 59;
		}
		.dark {
		    --color-primary: 29 78 216;
		    --color-darkmode-50: 87 103 132;
		    --color-darkmode-100: 74 90 121;
		    --color-darkmode-200: 65 81 114;
		    --color-darkmode-300: 53 69 103;
		    --color-darkmode-400: 48 61 93;
		    --color-darkmode-500: 41 53 82;
		    --color-darkmode-600: 40 51 78;
		    --color-darkmode-700: 35 45 69;
		    --color-darkmode-800: 27 37 59;
		    --color-darkmode-900: 15 23 42;
		}
		.theme-1 {
		    --color-theme-1: 6 95 70;
		    --color-theme-2: 6 78 59;
		    --color-primary: 6 78 59;
		    --color-secondary: 226 232 240;
		    --color-success: 5 150 105;
		    --color-info: 6 182 212;
		    --color-warning: 250 204 21;
		    --color-pending: 245 158 11;
		    --color-danger: 225 29 72;
		    --color-light: 241 245 249;
		    --color-dark: 30 41 59;
		}
		.theme-1.dark {
		    --color-primary: 6 95 70;
		}
		.theme-2 {
		    --color-theme-1: 30 58 138;
		    --color-theme-2: 23 37 84;
		    --color-primary: 23 37 84;
		    --color-secondary: 226 232 240;
		    --color-success: 13 148 136;
		    --color-info: 6 182 212;
		    --color-warning: 245 158 11;
		    --color-pending: 249 115 22;
		    --color-danger: 185 28 28;
		    --color-light: 241 245 249;
		    --color-dark: 30 41 59;
		}
		.theme-2.dark {
		    --color-primary: 30 64 175;
		}
		.theme-3 {
		    --color-theme-1: 21 94 117;
		    --color-theme-2: 22 78 99;
		    --color-primary: 22 78 99;
		    --color-secondary: 226 232 240;
		    --color-success: 13 148 136;
		    --color-info: 6 182 212;
		    --color-warning: 245 158 11;
		    --color-pending: 217 119 6;
		    --color-danger: 185 28 28;
		    --color-light: 241 245 249;
		    --color-dark: 30 41 59;
		}
		.theme-3.dark {
		    --color-primary: 21 94 117;
		}
		.theme-4 {
		    --color-theme-1: 55 48 163;
		    --color-theme-2: 49 46 129;
		    --color-primary: 49 46 129;
		    --color-secondary: 226 232 240;
		    --color-success: 5 150 105;
		    --color-info: 6 182 212;
		    --color-warning: 234 179 8;
		    --color-pending: 234 88 12;
		    --color-danger: 185 28 28;
		    --color-light: 241 245 249;
		    --color-dark: 30 41 59;
		}
		.theme-4.dark {
		    --color-primary: 67 56 202;
		}
		*, ::before, ::after {
		    --tw-border-spacing-x: 0;
		    --tw-border-spacing-y: 0;
		    --tw-translate-x: 0;
		    --tw-translate-y: 0;
		    --tw-rotate: 0;
		    --tw-skew-x: 0;
		    --tw-skew-y: 0;
		    --tw-scale-x: 1;
		    --tw-scale-y: 1;
		    --tw-pan-x:  ;
		    --tw-pan-y:  ;
		    --tw-pinch-zoom:  ;
		    --tw-scroll-snap-strictness: proximity;
		    --tw-gradient-from-position:  ;
		    --tw-gradient-via-position:  ;
		    --tw-gradient-to-position:  ;
		    --tw-ordinal:  ;
		    --tw-slashed-zero:  ;
		    --tw-numeric-figure:  ;
		    --tw-numeric-spacing:  ;
		    --tw-numeric-fraction:  ;
		    --tw-ring-inset:  ;
		    --tw-ring-offset-width: 0px;
		    --tw-ring-offset-color: #fff;
		    --tw-ring-color: rgb(59 130 246 / 0.5);
		    --tw-ring-offset-shadow: 0 0 #0000;
		    --tw-ring-shadow: 0 0 #0000;
		    --tw-shadow: 0 0 #0000;
		    --tw-shadow-colored: 0 0 #0000;
		    --tw-blur:  ;
		    --tw-brightness:  ;
		    --tw-contrast:  ;
		    --tw-grayscale:  ;
		    --tw-hue-rotate:  ;
		    --tw-invert:  ;
		    --tw-saturate:  ;
		    --tw-sepia:  ;
		    --tw-drop-shadow:  ;
		    --tw-backdrop-blur:  ;
		    --tw-backdrop-brightness:  ;
		    --tw-backdrop-contrast:  ;
		    --tw-backdrop-grayscale:  ;
		    --tw-backdrop-hue-rotate:  ;
		    --tw-backdrop-invert:  ;
		    --tw-backdrop-opacity:  ;
		    --tw-backdrop-saturate:  ;
		    --tw-backdrop-sepia:  ;
		}
		::backdrop {
		    --tw-border-spacing-x: 0;
		    --tw-border-spacing-y: 0;
		    --tw-translate-x: 0;
		    --tw-translate-y: 0;
		    --tw-rotate: 0;
		    --tw-skew-x: 0;
		    --tw-skew-y: 0;
		    --tw-scale-x: 1;
		    --tw-scale-y: 1;
		    --tw-pan-x:  ;
		    --tw-pan-y:  ;
		    --tw-pinch-zoom:  ;
		    --tw-scroll-snap-strictness: proximity;
		    --tw-gradient-from-position:  ;
		    --tw-gradient-via-position:  ;
		    --tw-gradient-to-position:  ;
		    --tw-ordinal:  ;
		    --tw-slashed-zero:  ;
		    --tw-numeric-figure:  ;
		    --tw-numeric-spacing:  ;
		    --tw-numeric-fraction:  ;
		    --tw-ring-inset:  ;
		    --tw-ring-offset-width: 0px;
		    --tw-ring-offset-color: #fff;
		    --tw-ring-color: rgb(59 130 246 / 0.5);
		    --tw-ring-offset-shadow: 0 0 #0000;
		    --tw-ring-shadow: 0 0 #0000;
		    --tw-shadow: 0 0 #0000;
		    --tw-shadow-colored: 0 0 #0000;
		    --tw-blur:  ;
		    --tw-brightness:  ;
		    --tw-contrast:  ;
		    --tw-grayscale:  ;
		    --tw-hue-rotate:  ;
		    --tw-invert:  ;
		    --tw-saturate:  ;
		    --tw-sepia:  ;
		    --tw-drop-shadow:  ;
		    --tw-backdrop-blur:  ;
		    --tw-backdrop-brightness:  ;
		    --tw-backdrop-contrast:  ;
		    --tw-backdrop-grayscale:  ;
		    --tw-backdrop-hue-rotate:  ;
		    --tw-backdrop-invert:  ;
		    --tw-backdrop-opacity:  ;
		    --tw-backdrop-saturate:  ;
		    --tw-backdrop-sepia:  ;
		}
		.container {
		    width: 100%;
		    margin-right: auto;
		    margin-left: auto;
		}
		@media (min-width: 640px) {
		    .container {
		        max-width: 640px;
		    }
		}
		@media (min-width: 768px) {
		    .container {
		        max-width: 768px;
		    }
		}
		@media (min-width: 1024px) {
		    .container {
		        max-width: 1024px;
		    }
		}
		@media (min-width: 1280px) {
		    .container {
		        max-width: 1280px;
		    }
		}
		@media (min-width: 1536px) {
		    .container {
		        max-width: 1536px;
		    }
		}
		.\!box {
		    box-shadow: 0px 3px 5px #0000000b !important;
		    background-color: white !important;
		    border: 1px solid #e2e8f0 !important;
		    border-radius: 0.6rem !important;
		    position: relative !important;
		  }
		.box {
		    box-shadow: 0px 3px 5px #0000000b;
		    background-color: white;
		    border: 1px solid #e2e8f0;
		    border-radius: 0.6rem;
		    position: relative;
		  }
		.dark .box {
		      background-color: rgb(var(--color-darkmode-600) / 1);
		      border-color: rgb(var(--color-darkmode-500) / 1);
		    }
		.dark .\!box {
		      background-color: rgb(var(--color-darkmode-600) / 1) !important;
		      border-color: rgb(var(--color-darkmode-500) / 1) !important;
		    }
		.dark .box--stacked:before {
		        background-color: rgb(var(--color-darkmode-600) / 70%);
		        border-color: rgb(100 116 139 / 60%);
		      }
		.image-fit {
		    position: relative;
		  }
		.image-fit > img {
		      position: absolute;
		      -o-object-fit: cover;
		         object-fit: cover;
		      top: 0;
		      width: 100%;
		      height: 100%;
		    }
		.scrollbar-hidden::-webkit-scrollbar {
		    width: 0px;
		    background-color: transparent;
		}
		.typing-dots span {
		    opacity: 0;
		}
		.typing-dots span:nth-child(1) {
		        animation: 1s type-animation infinite 0.33333s;
		      }
		.typing-dots span:nth-child(2) {
		        animation: 1s type-animation infinite 0.66666s;
		      }
		.typing-dots span:nth-child(3) {
		        animation: 1s type-animation infinite 0.99999s;
		      }
		@keyframes type-animation {
		    50% {
		        opacity: 1;
		    }
		  }
		.zoom-in {
		    transition-property: transform, box-shadow;
		    transition-duration: 300ms;
		    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
		    cursor: pointer;
		  }
		.zoom-in:hover {
		      transform: scale(1.05);
		      box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
		    }
		.visible {
		    visibility: visible;
		}
		.invisible {
		    visibility: hidden;
		}
		.collapse {
		    visibility: collapse;
		}
		.static {
		    position: static;
		}
		.fixed {
		    position: fixed;
		}
		.absolute {
		    position: absolute;
		}
		.relative {
		    position: relative;
		}
		.sticky {
		    position: sticky;
		}
		.inset-0 {
		    inset: 0px;
		}
		.inset-x-0 {
		    left: 0px;
		    right: 0px;
		}
		.inset-y-0 {
		    top: 0px;
		    bottom: 0px;
		}
		.bottom-0 {
		    bottom: 0px;
		}
		.bottom-\[100\%\] {
		    bottom: 100%;
		}
		.left-0 {
		    left: 0px;
		}
		.left-\[100\%\] {
		    left: 100%;
		}
		.left-\[50\%\] {
		    left: 50%;
		}
		.right-0 {
		    right: 0px;
		}
		.right-\[100\%\] {
		    right: 100%;
		}
		.right-auto {
		    right: auto;
		}
		.top-0 {
		    top: 0px;
		}
		.top-\[100\%\] {
		    top: 100%;
		}
		.top-\[50\%\] {
		    top: 50%;
		}
		.isolate {
		    isolation: isolate;
		}
		.z-10 {
		    z-index: 10;
		}
		.z-20 {
		    z-index: 20;
		}
		.z-30 {
		    z-index: 30;
		}
		.z-40 {
		    z-index: 40;
		}
		.z-50 {
		    z-index: 50;
		}
		.z-\[51\] {
		    z-index: 51;
		}
		.z-\[60\] {
		    z-index: 60;
		}
		.col-span-11 {
		    grid-column: span 11 / span 11;
		}
		.col-span-12 {
		    grid-column: span 12 / span 12;
		}
		.col-span-2 {
		    grid-column: span 2 / span 2;
		}
		.col-span-3 {
		    grid-column: span 3 / span 3;
		}
		.col-span-4 {
		    grid-column: span 4 / span 4;
		}
		.col-span-5 {
		    grid-column: span 5 / span 5;
		}
		.col-span-6 {
		    grid-column: span 6 / span 6;
		}
		.row-start-2 {
		    grid-row-start: 2;
		}
		.row-start-4 {
		    grid-row-start: 4;
		}
		.float-right {
		    float: right;
		}
		.float-left {
		    float: left;
		}
		.clear-both {
		    clear: both;
		}
		.m-5 {
		    margin: 1.25rem;
		}
		.m-auto {
		    margin: auto;
		}
		.-mx-2 {
		    margin-left: -0.5rem;
		    margin-right: -0.5rem;
		}
		.-mx-3 {
		    margin-left: -0.75rem;
		    margin-right: -0.75rem;
		}
		.-mx-5 {
		    margin-left: -1.25rem;
		    margin-right: -1.25rem;
		}
		.-mx-\[16px\] {
		    margin-left: -16px;
		    margin-right: -16px;
		}
		.-my-3 {
		    margin-top: -0.75rem;
		    margin-bottom: -0.75rem;
		}
		.-my-4 {
		    margin-top: -1rem;
		    margin-bottom: -1rem;
		}
		.mx-1 {
		    margin-left: 0.25rem;
		    margin-right: 0.25rem;
		}
		.mx-2 {
		    margin-left: 0.5rem;
		    margin-right: 0.5rem;
		}
		.mx-3 {
		    margin-left: 0.75rem;
		    margin-right: 0.75rem;
		}
		.mx-4 {
		    margin-left: 1rem;
		    margin-right: 1rem;
		}
		.mx-6 {
		    margin-left: 1.5rem;
		    margin-right: 1.5rem;
		}
		.mx-auto {
		    margin-left: auto;
		    margin-right: auto;
		}
		.my-10 {
		    margin-top: 2.5rem;
		    margin-bottom: 2.5rem;
		}
		.my-2 {
		    margin-top: 0.5rem;
		    margin-bottom: 0.5rem;
		}
		.my-4 {
		    margin-top: 1rem;
		    margin-bottom: 1rem;
		}
		.my-5 {
		    margin-top: 1.25rem;
		    margin-bottom: 1.25rem;
		}
		.my-6 {
		    margin-top: 1.5rem;
		    margin-bottom: 1.5rem;
		}
		.my-auto {
		    margin-top: auto;
		    margin-bottom: auto;
		}
		.-mb-1 {
		    margin-bottom: -0.25rem;
		}
		.-mb-1\.5 {
		    margin-bottom: -0.375rem;
		}
		.-mb-10 {
		    margin-bottom: -2.5rem;
		}
		.-mb-6 {
		    margin-bottom: -1.5rem;
		}
		.-mb-7 {
		    margin-bottom: -1.75rem;
		}
		.-mb-px {
		    margin-bottom: -1px;
		}
		.-ml-0 {
		    margin-left: -0px;
		}
		.-ml-0\.5 {
		    margin-left: -0.125rem;
		}
		.-ml-1 {
		    margin-left: -0.25rem;
		}
		.-ml-12 {
		    margin-left: -3rem;
		}
		.-ml-2 {
		    margin-left: -0.5rem;
		}
		.-ml-2\.5 {
		    margin-left: -0.625rem;
		}
		.-ml-4 {
		    margin-left: -1rem;
		}
		.-ml-5 {
		    margin-left: -1.25rem;
		}
		.-ml-\[100\%\] {
		    margin-left: -100%;
		}
		.-ml-\[228px\] {
		    margin-left: -228px;
		}
		.-ml-\[60px\] {
		    margin-left: -60px;
		}
		.-mr-1 {
		    margin-right: -0.25rem;
		}
		.-mr-12 {
		    margin-right: -3rem;
		}
		.-mr-2 {
		    margin-right: -0.5rem;
		}
		.-mr-5 {
		    margin-right: -1.25rem;
		}
		.-mr-\[100\%\] {
		    margin-right: -100%;
		}
		.-mt-0 {
		    margin-top: -0px;
		}
		.-mt-0\.5 {
		    margin-top: -0.125rem;
		}
		.-mt-1 {
		    margin-top: -0.25rem;
		}
		.-mt-1\.5 {
		    margin-top: -0.375rem;
		}
		.-mt-12 {
		    margin-top: -3rem;
		}
		.-mt-16 {
		    margin-top: -4rem;
		}
		.-mt-2 {
		    margin-top: -0.5rem;
		}
		.-mt-3 {
		    margin-top: -0.75rem;
		}
		.-mt-4 {
		    margin-top: -1rem;
		}
		.-mt-8 {
		    margin-top: -2rem;
		}
		.-mt-\[3px\] {
		    margin-top: -3px;
		}
		.-mt-\[7px\] {
		    margin-top: -7px;
		}
		.mb-0 {
		    margin-bottom: 0px;
		}
		.mb-0\.5 {
		    margin-bottom: 0.125rem;
		}
		.mb-1 {
		    margin-bottom: 0.25rem;
		}
		.mb-10 {
		    margin-bottom: 2.5rem;
		}
		.mb-12 {
		    margin-bottom: 3rem;
		}
		.mb-2 {
		    margin-bottom: 0.5rem;
		}
		.mb-3 {
		    margin-bottom: 0.75rem;
		}
		.mb-4 {
		    margin-bottom: 1rem;
		}
		.mb-5 {
		    margin-bottom: 1.25rem;
		}
		.mb-6 {
		    margin-bottom: 1.5rem;
		}
		.mb-8 {
		    margin-bottom: 2rem;
		}
		.ml-0 {
		    margin-left: 0px;
		}
		.ml-0\.5 {
		    margin-left: 0.125rem;
		}
		.ml-1 {
	    margin-left: 0.25rem;
		}
		.ml-1\.5 {
		    margin-left: 0.375rem;
		}
		.ml-2 {
		    margin-left: 0.5rem;
		}
		.ml-3 {
		    margin-left: 0.75rem;
		}
		.ml-3\.5 {
		    margin-left: 0.875rem;
		}
		.ml-4 {
		    margin-left: 1rem;
		}
		.ml-5 {
		    margin-left: 1.25rem;
		}
		.ml-6 {
		    margin-left: 1.5rem;
		}
		.ml-8 {
		    margin-left: 2rem;
		}
		.ml-auto {
		    margin-left: auto;
		}
		.mr-0 {
		    margin-right: 0px;
		}
		.mr-0\.5 {
		    margin-right: 0.125rem;
		}
		.mr-1 {
		    margin-right: 0.25rem;
		}
		.mr-2 {
		    margin-right: 0.5rem;
		}
		.mr-3 {
		    margin-right: 0.75rem;
		}
		.mr-4 {
		    margin-right: 1rem;
		}
		.mr-5 {
		    margin-right: 1.25rem;
		}
		.mr-6 {
		    margin-right: 1.5rem;
		}
		.mr-auto {
		    margin-right: auto;
		}
		.mt-0 {
		    margin-top: 0px;
		}
		.mt-0\.5 {
		    margin-top: 0.125rem;
		}
		.mt-1 {
		    margin-top: 0.25rem;
		}
		.mt-1\.5 {
		    margin-top: 0.375rem;
		}
		.mt-10 {
		    margin-top: 2.5rem;
		}
		.mt-12 {
		    margin-top: 3rem;
		}
		.mt-14 {
		    margin-top: 3.5rem;
		}
		.mt-16 {
		    margin-top: 4rem;
		}
		.mt-2 {
		    margin-top: 0.5rem;
		}
		.mt-2\.5 {
		    margin-top: 0.625rem;
		}
		.mt-20 {
		    margin-top: 5rem;
		}
		.mt-3 {
		    margin-top: 0.75rem;
		}
		.mt-3\.5 {
		    margin-top: 0.875rem;
		}
		.mt-4 {
		    margin-top: 1rem;
		}
		.mt-5 {
		    margin-top: 1.25rem;
		}
		.mt-6 {
		    margin-top: 1.5rem;
		}
		.mt-8 {
		    margin-top: 2rem;
		}
		.mt-\[2\.2rem\] {
		    margin-top: 2.2rem;
		}
		.mt-\[3px\] {
		    margin-top: 3px;
		}
		.mt-\[4\.7rem\] {
		    margin-top: 4.7rem;
		}
		.mt-px {
		    margin-top: 1px;
		}
		.block {
		    display: block;
		}
		.inline-block {
		    display: inline-block;
		}
		.inline {
		    display: inline;
		}
		.flex {
		    display: flex;
		}
		.inline-flex {
		    display: inline-flex;
		}
		.table {
		    display: table;
		}
		.grid {
		    display: grid;
		}
		.contents {
		    display: contents;
		}
		.hidden {
		    display: none;
		}
		.h-0 {
		    height: 0px;
		}
		.h-1 {
		    height: 0.25rem;
		}
		.h-10 {
		    height: 2.5rem;
		}
		.h-12 {
		    height: 3rem;
		}
		.h-14 {
		    height: 3.5rem;
		}
		.h-16 {
		    height: 4rem;
		}
		.h-2 {
		    height: 0.5rem;
		}
		.h-20 {
		    height: 5rem;
		}
		.h-24 {
		    height: 6rem;
		}
		.h-28 {
		    height: 7rem;
		}
		.h-3 {
		    height: 0.75rem;
		}
		.h-32 {
		    height: 8rem;
		}
		.h-4 {
		    height: 1rem;
		}
		.h-40 {
		    height: 10rem;
		}
		.h-48 {
		    height: 12rem;
		}
		.h-5 {
		    height: 1.25rem;
		}
		.h-56 {
		    height: 14rem;
		}
		.h-6 {
		    height: 1.5rem;
		}
		.h-64 {
		    height: 16rem;
		}
		.h-8 {
		    height: 2rem;
		}
		.h-9 {
		    height: 2.25rem;
		}
		.h-\[200\%\] {
		    height: 200%;
		}
		.h-\[24px\] {
		    height: 24px;
		}
		.h-\[250px\] {
		    height: 250px;
		}
		.h-\[28px\] {
		    height: 28px;
		}
		.h-\[310px\] {
		    height: 310px;
		}
		.h-\[320px\] {
		    height: 320px;
		}
		.h-\[364px\] {
		    height: 364px;
		}
		.h-\[45px\] {
		    height: 45px;
		}
		.h-\[46px\] {
		    height: 46px;
		}
		.h-\[50px\] {
		    height: 50px;
		}
		.h-\[525px\] {
		    height: 525px;
		}
		.h-\[58px\] {
		    height: 58px;
		}
		.h-\[67px\] {
		    height: 67px;
		}
		.h-\[69px\] {
		    height: 69px;
		}
		.h-\[70px\] {
		    height: 70px;
		}
		.h-\[782px\] {
		    height: 782px;
		}
		.h-full {
		    height: 100%;
		}
		.h-px {
		    height: 1px;
		}
		.h-screen {
		    height: 100vh;
		}
		.max-h-0 {
		    max-height: 0px;
		}
		.max-h-\[2000px\] {
		    max-height: 2000px;
		}
		.max-h-full {
		    max-height: 100%;
		}
		.min-h-\[400px\] {
		    min-height: 400px;
		}
		.min-h-screen {
		    min-height: 100vh;
		}
		.min-h-full {
		    min-height: 100%;
		}
		.w-0 {
		    width: 0px;
		}
		.w-1\/2 {
		    width: 50%;
		}
		.w-1\/4 {
		    width: 25%;
		}
		.w-10 {
		    width: 2.5rem;
		}
		.w-10\/12 {
		    width: 83.333333%;
		}
		.w-12 {
		    width: 3rem;
		}
		.w-14 {
		    width: 3.5rem;
		}
		.w-16 {
		    width: 4rem;
		}
		.w-2 {
		    width: 0.5rem;
		}
		.w-2\/3 {
		    width: 66.666667%;
		}
		.w-2\/4 {
		    width: 50%;
		}
		.w-2\/5 {
		    width: 40%;
		}
		.w-20 {
		    width: 5rem;
		}
		.w-24 {
		    width: 6rem;
		}
		.w-3 {
		    width: 0.75rem;
		}
		.w-3\/4 {
		    width: 75%;
		}
		.w-3\/5 {
		    width: 60%;
		}
		.w-32 {
		    width: 8rem;
		}
		.w-4 {
		    width: 1rem;
		}
		.w-4\/5 {
		    width: 80%;
		}
		.w-40 {
		    width: 10rem;
		}
		.w-44 {
		    width: 11rem;
		}
		.w-48 {
		    width: 12rem;
		}
		.w-5 {
		    width: 1.25rem;
		}
		.w-5\/6 {
		    width: 83.333333%;
		}
		.w-52 {
		    width: 13rem;
		}
		.w-56 {
		    width: 14rem;
		}
		.w-6 {
		    width: 1.5rem;
		}
		.w-60 {
		    width: 15rem;
		}
		.w-64 {
		    width: 16rem;
		}
		.w-72 {
		    width: 18rem;
		}
		.w-8 {
		    width: 2rem;
		}
		.w-9 {
		    width: 2.25rem;
		}
		.w-\[100px\] {
		    width: 100px;
		}
		.w-\[270px\] {
		    width: 270px;
		}
		.w-\[280px\] {
		    width: 280px;
		}
		.w-\[28px\] {
		    width: 28px;
		}
		.w-\[320px\] {
		    width: 320px;
		}
		.w-\[38px\] {
		    width: 38px;
		}
		.w-\[450px\] {
		    width: 450px;
		}
		.w-\[478px\] {
		    width: 478px;
		}
		.w-\[80px\] {
		    width: 80px;
		}
		.w-\[90\%\] {
		    width: 90%;
		}
		.w-auto {
		    width: auto;
		}
		.w-full {
		    width: 100%;
		}
		.w-px {
		    width: 1px;
		}
		.w-1\/6 {
		    width: 16.666667%;
		}
		.w-screen {
		    width: 100vw;
		}
		.min-w-0 {
		    min-width: 0px;
		}
		.min-w-\[6rem\] {
		    min-width: 6rem;
		}
		.min-w-full {
		    min-width: 100%;
		}
		.max-w-\[50\%\] {
		    max-width: 50%;
		}
		.max-w-\[90\%\] {
		    max-width: 90%;
		}
		.max-w-full {
		    max-width: 100%;
		}
		.flex-1 {
		    flex: 1 1 0%;
		}
		.flex-none {
		    flex: none;
		}
		.border-separate {
		    border-collapse: separate;
		}
		.border-spacing-y-\[10px\] {
		    --tw-border-spacing-y: 10px;
		    border-spacing: var(--tw-border-spacing-x) var(--tw-border-spacing-y);
		}
		.translate-x-\[-50\%\] {
		    --tw-translate-x: -50%;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.translate-x-\[50px\] {
		    --tw-translate-x: 50px;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.translate-y-0 {
		    --tw-translate-y: 0px;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.translate-y-1 {
		    --tw-translate-y: 0.25rem;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.translate-y-\[-50\%\] {
		    --tw-translate-y: -50%;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.translate-y-\[35px\] {
		    --tw-translate-y: 35px;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.translate-y-\[50px\] {
		    --tw-translate-y: 50px;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.-rotate-90 {
		    --tw-rotate: -90deg;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.rotate-12 {
		    --tw-rotate: 12deg;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.rotate-180 {
		    --tw-rotate: 180deg;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.scale-105 {
		    --tw-scale-x: 1.05;
		    --tw-scale-y: 1.05;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.scale-110 {
		    --tw-scale-x: 1.1;
		    --tw-scale-y: 1.1;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.transform {
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.animate-\[0\.4s_ease-in-out_0\.1s_intro-divider\] {
		    animation: 0.4s ease-in-out 0.1s intro-divider;
		}
		.animate-\[0\.4s_ease-in-out_0\.1s_intro-menu\] {
		    animation: 0.4s ease-in-out 0.1s intro-menu;
		}
		@keyframes spin {
		    to {
		        transform: rotate(360deg);
		    }
		}
		.animate-spin {
		    animation: spin 1s linear infinite;
		}
		.cursor-pointer {
		    cursor: pointer;
		}
		.cursor-text {
		    cursor: text;
		}
		.select-none {
		    -webkit-user-select: none;
		       -moz-user-select: none;
		            user-select: none;
		}
		.resize-none {
		    resize: none;
		}
		.resize {
		    resize: both;
		}
		.appearance-none {
		    -webkit-appearance: none;
		       -moz-appearance: none;
		            appearance: none;
		}
		.grid-cols-1 {
		    grid-template-columns: repeat(1, minmax(0, 1fr));
		}
		.grid-cols-10 {
		    grid-template-columns: repeat(10, minmax(0, 1fr));
		}
		.grid-cols-11 {
		    grid-template-columns: repeat(11, minmax(0, 1fr));
		}
		.grid-cols-12 {
		    grid-template-columns: repeat(12, minmax(0, 1fr));
		}
		.grid-cols-2 {
		    grid-template-columns: repeat(2, minmax(0, 1fr));
		}
		.grid-cols-3 {
		    grid-template-columns: repeat(3, minmax(0, 1fr));
		}
		.grid-cols-4 {
		    grid-template-columns: repeat(4, minmax(0, 1fr));
		}
		.grid-cols-7 {
		    grid-template-columns: repeat(7, minmax(0, 1fr));
		}
		.grid-cols-8 {
		    grid-template-columns: repeat(8, minmax(0, 1fr));
		}
		.flex-col {
		    flex-direction: column;
		}
		.flex-col-reverse {
		    flex-direction: column-reverse;
		}
		.flex-wrap {
		    flex-wrap: wrap;
		}
		.items-start {
		    align-items: flex-start;
		}
		.items-end {
		    align-items: flex-end;
		}
		.items-center {
		    align-items: center;
		}
		.justify-start {
		    justify-content: flex-start;
		}
		.justify-end {
		    justify-content: flex-end;
		}
		.justify-center {
		    justify-content: center;
		}
		.justify-between {
		    justify-content: space-between;
		}
		.gap-1 {
		    gap: 0.25rem;
		}
		.gap-2 {
		    gap: 0.5rem;
		}
		.gap-3 {
		    gap: 0.75rem;
		}
		.gap-3\.5 {
		    gap: 0.875rem;
		}
		.gap-4 {
		    gap: 1rem;
		}
		.gap-5 {
		    gap: 1.25rem;
		}
		.gap-6 {
		    gap: 1.5rem;
		}
		.gap-x-10 {
		    -moz-column-gap: 2.5rem;
		         column-gap: 2.5rem;
		}
		.gap-x-5 {
		    -moz-column-gap: 1.25rem;
		         column-gap: 1.25rem;
		}
		.gap-x-6 {
		    -moz-column-gap: 1.5rem;
		         column-gap: 1.5rem;
		}
		.gap-y-3 {
		    row-gap: 0.75rem;
		}
		.gap-y-3\.5 {
		    row-gap: 0.875rem;
		}
		.gap-y-5 {
		    row-gap: 1.25rem;
		}
		.gap-y-6 {
		    row-gap: 1.5rem;
		}
		.gap-y-8 {
		    row-gap: 2rem;
		}
		.overflow-auto {
		    overflow: auto;
		}
		.overflow-hidden {
		    overflow: hidden;
		}
		.overflow-x-auto {
		    overflow-x: auto;
		}
		.overflow-y-auto {
		    overflow-y: auto;
		}
		.overflow-x-hidden {
		    overflow-x: hidden;
		}
		.overflow-y-scroll {
		    overflow-y: scroll;
		}
		.truncate {
		    overflow: hidden;
		    text-overflow: ellipsis;
		    white-space: nowrap;
		}
		.whitespace-nowrap {
		    white-space: nowrap;
		}
		.rounded {
		    border-radius: 0.25rem;
		}
		.rounded-\[1\.3rem\] {
		    border-radius: 1.3rem;
		}
		.rounded-\[30px\] {
		    border-radius: 30px;
		}
		.rounded-full {
		    border-radius: 9999px;
		}
		.rounded-lg {
		    border-radius: 0.5rem;
		}
		.rounded-md {
		    border-radius: 0.375rem;
		}
		.rounded-none {
		    border-radius: 0px;
		}
		.rounded-l {
		    border-top-left-radius: 0.25rem;
		    border-bottom-left-radius: 0.25rem;
		}
		.rounded-l-md {
		    border-top-left-radius: 0.375rem;
		    border-bottom-left-radius: 0.375rem;
		}
		.rounded-l-none {
		    border-top-left-radius: 0px;
		    border-bottom-left-radius: 0px;
		}
		.rounded-r-md {
		    border-top-right-radius: 0.375rem;
		    border-bottom-right-radius: 0.375rem;
		}
		.rounded-r-none {
		    border-top-right-radius: 0px;
		    border-bottom-right-radius: 0px;
		}
		.rounded-t-md {
		    border-top-left-radius: 0.375rem;
		    border-top-right-radius: 0.375rem;
		}
		.border {
		    border-width: 1px;
		}
		.border-0 {
		    border-width: 0px;
		}
		.border-2 {
		    border-width: 2px;
		}
		.border-x-0 {
		    border-left-width: 0px;
		    border-right-width: 0px;
		}
		.border-b {
		    border-bottom-width: 1px;
		}
		.border-b-0 {
		    border-bottom-width: 0px;
		}
		.border-b-2 {
		    border-bottom-width: 2px;
		}
		.border-l {
		    border-left-width: 1px;
		}
		.border-l-2 {
		    border-left-width: 2px;
		}
		.border-r {
		    border-right-width: 1px;
		}
		.border-t {
		    border-top-width: 1px;
		}
		.border-dashed {
		    border-style: dashed;
		}
		.border-dotted {
		    border-style: dotted;
		}
		.border-\[\#0077b5\] {
		    --tw-border-opacity: 1;
		    border-color: rgb(0 119 181 / var(--tw-border-opacity));
		}
		.border-\[\#3b5998\] {
		    --tw-border-opacity: 1;
		    border-color: rgb(59 89 152 / var(--tw-border-opacity));
		}
		.border-\[\#4ab3f4\] {
		    --tw-border-opacity: 1;
		    border-color: rgb(74 179 244 / var(--tw-border-opacity));
		}
		.border-\[\#517fa4\] {
		    --tw-border-opacity: 1;
		    border-color: rgb(81 127 164 / var(--tw-border-opacity));
		}
		.border-black {
		    --tw-border-opacity: 1;
		    border-color: rgb(0 0 0 / var(--tw-border-opacity));
		}
		.border-danger {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-danger) / var(--tw-border-opacity));
		}
		.border-dark {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-dark) / var(--tw-border-opacity));
		}
		.border-pending {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-pending) / var(--tw-border-opacity));
		}
		.border-primary {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-primary) / var(--tw-border-opacity));
		}
		.border-secondary {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-secondary) / var(--tw-border-opacity));
		}
		.border-secondary\/70 {
		    border-color: rgb(var(--color-secondary) / 0.7);
		}
		.border-slate-200 {
		    --tw-border-opacity: 1;
		    border-color: rgb(226 232 240 / var(--tw-border-opacity));
		}
		.border-slate-200\/60 {
		    border-color: rgb(226 232 240 / 0.6);
		}
		.border-slate-300 {
		    --tw-border-opacity: 1;
		    border-color: rgb(203 213 225 / var(--tw-border-opacity));
		}
		.border-slate-300\/80 {
		    border-color: rgb(203 213 225 / 0.8);
		}
		.border-slate-400 {
		    --tw-border-opacity: 1;
		    border-color: rgb(148 163 184 / var(--tw-border-opacity));
		}
		.border-slate-600 {
		    --tw-border-opacity: 1;
		    border-color: rgb(71 85 105 / var(--tw-border-opacity));
		}
		.border-success {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-success) / var(--tw-border-opacity));
		}
		.border-theme-1\/60 {
		    border-color: rgb(var(--color-theme-1) / 0.6);
		}
		.border-transparent {
		    border-color: transparent;
		}
		.border-warning {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-warning) / var(--tw-border-opacity));
		}
		.border-white {
		    --tw-border-opacity: 1;
		    border-color: rgb(255 255 255 / var(--tw-border-opacity));
		}
		.border-white\/10 {
		    border-color: rgb(255 255 255 / 0.1);
		}
		.border-white\/90 {
		    border-color: rgb(255 255 255 / 0.9);
		}
		.border-white\/\[0\.08\] {
		    border-color: rgb(255 255 255 / 0.08);
		}
		.border-b-primary {
		    --tw-border-opacity: 1;
		    border-bottom-color: rgb(var(--color-primary) / var(--tw-border-opacity));
		}
		.border-b-transparent {
		    border-bottom-color: transparent;
		}
		.border-opacity-10 {
		    --tw-border-opacity: 0.1;
		}
		.border-opacity-5 {
		    --tw-border-opacity: 0.05;
		}
		.bg-\[\#0077b5\] {
		    --tw-bg-opacity: 1;
		    background-color: rgb(0 119 181 / var(--tw-bg-opacity));
		}
		.bg-\[\#3b5998\] {
		    --tw-bg-opacity: 1;
		    background-color: rgb(59 89 152 / var(--tw-bg-opacity));
		}
		.bg-\[\#4ab3f4\] {
		    --tw-bg-opacity: 1;
		    background-color: rgb(74 179 244 / var(--tw-bg-opacity));
		}
		.bg-\[\#517fa4\] {
		    --tw-bg-opacity: 1;
		    background-color: rgb(81 127 164 / var(--tw-bg-opacity));
		}
		.bg-black\/60 {
		    background-color: rgb(0 0 0 / 0.6);
		}
		.bg-danger {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-danger) / var(--tw-bg-opacity));
		}
		.bg-danger\/20 {
		    background-color: rgb(var(--color-danger) / 0.2);
		}
		.bg-dark {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-dark) / var(--tw-bg-opacity));
		}
		.bg-darkmode-400\/70 {
		    background-color: rgb(var(--color-darkmode-400) / 0.7);
		}
		.bg-darkmode-600 {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-600) / var(--tw-bg-opacity));
		}
		.bg-pending {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-pending) / var(--tw-bg-opacity));
		}
		.bg-pending\/10 {
		    background-color: rgb(var(--color-pending) / 0.1);
		}
		.bg-pending\/20 {
		    background-color: rgb(var(--color-pending) / 0.2);
		}
		.bg-pending\/80 {
		    background-color: rgb(var(--color-pending) / 0.8);
		}
		.bg-primary {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-primary) / var(--tw-bg-opacity));
		}
		.bg-primary\/10 {
		    background-color: rgb(var(--color-primary) / 0.1);
		}
		.bg-primary\/70 {
		    background-color: rgb(var(--color-primary) / 0.7);
		}
		.bg-primary\/80 {
		    background-color: rgb(var(--color-primary) / 0.8);
		}
		.bg-secondary\/70 {
		    background-color: rgb(var(--color-secondary) / 0.7);
		}
		.bg-slate-100 {
		    --tw-bg-opacity: 1;
		    background-color: rgb(241 245 249 / var(--tw-bg-opacity));
		}
		.bg-slate-200 {
		    --tw-bg-opacity: 1;
		    background-color: rgb(226 232 240 / var(--tw-bg-opacity));
		}
		.bg-slate-200\/60 {
		    background-color: rgb(226 232 240 / 0.6);
		}
		.bg-slate-300 {
		    --tw-bg-opacity: 1;
		    background-color: rgb(203 213 225 / var(--tw-bg-opacity));
		}
		.bg-slate-300\/50 {
		    background-color: rgb(203 213 225 / 0.5);
		}
		.bg-slate-50 {
		    --tw-bg-opacity: 1;
		    background-color: rgb(248 250 252 / var(--tw-bg-opacity));
		}
		.bg-slate-500 {
		    --tw-bg-opacity: 1;
		    background-color: rgb(100 116 139 / var(--tw-bg-opacity));
		}
		.bg-slate-900 {
		    --tw-bg-opacity: 1;
		    background-color: rgb(15 23 42 / var(--tw-bg-opacity));
		}
		.bg-success {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-success) / var(--tw-bg-opacity));
		}
		.bg-success\/20 {
		    background-color: rgb(var(--color-success) / 0.2);
		}
		.bg-theme-1 {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-theme-1) / var(--tw-bg-opacity));
		}
		.bg-theme-1\/90 {
		    background-color: rgb(var(--color-theme-1) / 0.9);
		}
		.bg-theme-2 {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-theme-2) / var(--tw-bg-opacity));
		}
		.bg-transparent {
		    background-color: transparent;
		}
		.bg-warning {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-warning) / var(--tw-bg-opacity));
		}
		.bg-warning\/20 {
		    background-color: rgb(var(--color-warning) / 0.2);
		}
		.bg-white {
		    --tw-bg-opacity: 1;
		    background-color: rgb(255 255 255 / var(--tw-bg-opacity));
		}
		.bg-white\/10 {
		    background-color: rgb(255 255 255 / 0.1);
		}
		.bg-white\/20 {
		    background-color: rgb(255 255 255 / 0.2);
		}
		.bg-white\/5 {
		    background-color: rgb(255 255 255 / 0.05);
		}
		.bg-white\/\[0\.08\] {
		    background-color: rgb(255 255 255 / 0.08);
		}
		.bg-yellow-200 {
		    --tw-bg-opacity: 1;
		    background-color: rgb(254 240 138 / var(--tw-bg-opacity));
		}
		.bg-opacity-10 {
		    --tw-bg-opacity: 0.1;
		}
		.bg-opacity-20 {
		    --tw-bg-opacity: 0.2;
		}
		.bg-gradient-to-b {
		    background-image: linear-gradient(to bottom, var(--tw-gradient-stops));
		}
		.from-theme-1 {
		    --tw-gradient-from: rgb(var(--color-theme-1) / 1) var(--tw-gradient-from-position);
		    --tw-gradient-to: rgb(var(--color-theme-1) / 0) var(--tw-gradient-to-position);
		    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
		}
		.to-theme-2 {
		    --tw-gradient-to: rgb(var(--color-theme-2) / 1) var(--tw-gradient-to-position);
		}
		.bg-contain {
		    background-size: contain;
		}
		.bg-center {
		    background-position: center;
		}
		.bg-no-repeat {
		    background-repeat: no-repeat;
		}
		.fill-current {
		    fill: currentColor;
		}
		.fill-pending\/30 {
		    fill: rgb(var(--color-pending) / 0.3);
		}
		.stroke-1 {
		    stroke-width: 1;
		}
		.stroke-1\.5 {
		    stroke-width: 1.5;
		}
		.stroke-\[1\] {
		    stroke-width: 1;
		}
		.p-0 {
		    padding: 0px;
		}
		.p-1 {
		    padding: 0.25rem;
		}
		.p-10 {
		    padding: 2.5rem;
		}
		.p-2 {
		    padding: 0.5rem;
		}
		.p-3 {
		    padding: 0.75rem;
		}
		.p-4 {
		    padding: 1rem;
		}
		.p-5 {
		    padding: 1.25rem;
		}
		.p-8 {
		    padding: 2rem;
		}
		.p-px {
		    padding: 1px;
		}
		.\!px-2 {
		    padding-left: 0.5rem !important;
		    padding-right: 0.5rem !important;
		}
		.\!py-3 {
		    padding-top: 0.75rem !important;
		    padding-bottom: 0.75rem !important;
		}
		.\!py-3\.5 {
		    padding-top: 0.875rem !important;
		    padding-bottom: 0.875rem !important;
		}
		.\!py-4 {
		    padding-top: 1rem !important;
		    padding-bottom: 1rem !important;
		}
		.\!py-5 {
		    padding-top: 1.25rem !important;
		    padding-bottom: 1.25rem !important;
		}
		.px-0 {
		    padding-left: 0px;
		    padding-right: 0px;
		}
		.px-1 {
		    padding-left: 0.25rem;
		    padding-right: 0.25rem;
		}
		.px-10 {
		    padding-left: 2.5rem;
		    padding-right: 2.5rem;
		}
		.px-2 {
		    padding-left: 0.5rem;
		    padding-right: 0.5rem;
		}
		.px-2\.5 {
		    padding-left: 0.625rem;
		    padding-right: 0.625rem;
		}
		.px-3 {
		    padding-left: 0.75rem;
		    padding-right: 0.75rem;
		}
		.px-4 {
		    padding-left: 1rem;
		    padding-right: 1rem;
		}
		.px-5 {
		    padding-left: 1.25rem;
		    padding-right: 1.25rem;
		}
		.px-6 {
		    padding-left: 1.5rem;
		    padding-right: 1.5rem;
		}
		.px-8 {
		    padding-left: 2rem;
		    padding-right: 2rem;
		}
		.px-\[22px\] {
		    padding-left: 22px;
		    padding-right: 22px;
		}
		.py-0 {
		    padding-top: 0px;
		    padding-bottom: 0px;
		}
		.py-0\.5 {
		    padding-top: 0.125rem;
		    padding-bottom: 0.125rem;
		}
		.py-1 {
		    padding-top: 0.25rem;
		    padding-bottom: 0.25rem;
		}
		.py-1\.5 {
		    padding-top: 0.375rem;
		    padding-bottom: 0.375rem;
		}
		.py-10 {
		    padding-top: 2.5rem;
		    padding-bottom: 2.5rem;
		}
		.py-12 {
		    padding-top: 3rem;
		    padding-bottom: 3rem;
		}
		.py-16 {
		    padding-top: 4rem;
		    padding-bottom: 4rem;
		}
		.py-2 {
		    padding-top: 0.5rem;
		    padding-bottom: 0.5rem;
		}
		.py-2\.5 {
		    padding-top: 0.625rem;
		    padding-bottom: 0.625rem;
		}
		.py-3 {
		    padding-top: 0.75rem;
		    padding-bottom: 0.75rem;
		}
		.py-4 {
		    padding-top: 1rem;
		    padding-bottom: 1rem;
		}
		.py-5 {
		    padding-top: 1.25rem;
		    padding-bottom: 1.25rem;
		}
		.py-6 {
		    padding-top: 1.5rem;
		    padding-bottom: 1.5rem;
		}
		.py-8 {
		    padding-top: 2rem;
		    padding-bottom: 2rem;
		}
		.py-\[3px\] {
		    padding-top: 3px;
		    padding-bottom: 3px;
		}
		.\!pl-2 {
		    padding-left: 0.5rem !important;
		}
		.\!pl-4 {
		    padding-left: 1rem !important;
		}
		.\!pr-2 {
		    padding-right: 0.5rem !important;
		}
		.pb-10 {
		    padding-bottom: 2.5rem;
		}
		.pb-14 {
		    padding-bottom: 3.5rem;
		}
		.pb-16 {
		    padding-bottom: 4rem;
		}
		.pb-2 {
		    padding-bottom: 0.5rem;
		}
		.pb-20 {
		    padding-bottom: 5rem;
		}
		.pb-3 {
		    padding-bottom: 0.75rem;
		}
		.pb-4 {
		    padding-bottom: 1rem;
		}
		.pb-5 {
		    padding-bottom: 1.25rem;
		}
		.pb-6 {
		    padding-bottom: 1.5rem;
		}
		.pb-8 {
		    padding-bottom: 2rem;
		}
		.pl-0 {
		    padding-left: 0px;
		}
		.pl-0\.5 {
		    padding-left: 0.125rem;
		}
		.pl-1 {
		    padding-left: 0.25rem;
		}
		.pl-10 {
		    padding-left: 2.5rem;
		}
		.pl-12 {
		    padding-left: 3rem;
		}
		.pl-16 {
		    padding-left: 4rem;
		}
		.pl-2 {
		    padding-left: 0.5rem;
		}
		.pl-3 {
		    padding-left: 0.75rem;
		}
		.pl-3\.5 {
		    padding-left: 0.875rem;
		}
		.pl-4 {
		    padding-left: 1rem;
		}
		.pl-5 {
		    padding-left: 1.25rem;
		}
		.pr-1 {
		    padding-right: 0.25rem;
		}
		.pr-10 {
		    padding-right: 2.5rem;
		}
		.pr-14 {
		    padding-right: 3.5rem;
		}
		.pr-16 {
		    padding-right: 4rem;
		}
		.pr-5 {
		    padding-right: 1.25rem;
		}
		.pr-8 {
		    padding-right: 2rem;
		}
		.pt-0 {
		    padding-top: 0px;
		}
		.pt-0\.5 {
		    padding-top: 0.125rem;
		}
		.pt-1 {
		    padding-top: 0.25rem;
		}
		.pt-10 {
		    padding-top: 2.5rem;
		}
		.pt-16 {
		    padding-top: 4rem;
		}
		.pt-2 {
		    padding-top: 0.5rem;
		}
		.pt-3 {
		    padding-top: 0.75rem;
		}
		.pt-32 {
		    padding-top: 8rem;
		}
		.pt-4 {
		    padding-top: 1rem;
		}
		.pt-5 {
		    padding-top: 1.25rem;
		}
		.pt-6 {
		    padding-top: 1.5rem;
		}
		.pt-8 {
		    padding-top: 2rem;
		}
		.text-left {
		    text-align: left;
		}
		.text-center {
		    text-align: center;
		}
		.text-right {
		    text-align: right;
		}
		.text-justify {
		    text-align: justify;
		}
		.indent-\[30px\] {
		    text-indent: 30px;
		}
		.align-top {
		    vertical-align: top;
		}
		.text-2xl {
		    font-size: 1.5rem;
		    line-height: 2rem;
		}
		.text-3xl {
		    font-size: 1.875rem;
		    line-height: 2.25rem;
		}
		.text-4xl {
		    font-size: 2.25rem;
		    line-height: 2.5rem;
		}
		.text-5xl {
		    font-size: 3rem;
		    line-height: 1;
		}
		.text-8xl {
		    font-size: 6rem;
		    line-height: 1;
		}
		.text-base {
		    font-size: 1rem;
		    line-height: 1.5rem;
		}
		.text-lg {
		    font-size: 1.125rem;
		    line-height: 1.75rem;
		}
		.text-sm {
		    font-size: 0.875rem;
		    line-height: 1.25rem;
		}
		.text-xl {
		    font-size: 1.25rem;
		    line-height: 1.75rem;
		}
		.text-xs {
		    font-size: 0.75rem;
		    line-height: 1rem;
		}
		.font-bold {
		    font-weight: 700;
		}
		.font-extrabold {
		    font-weight: 800;
		}
		.font-medium {
		    font-weight: 500;
		}
		.font-normal {
		    font-weight: 400;
		}
		.font-semibold {
		    font-weight: 600;
		}
		.uppercase {
		    text-transform: uppercase;
		}
		.lowercase {
		    text-transform: lowercase;
		}
		.capitalize {
		    text-transform: capitalize;
		}
		.normal-case {
		    text-transform: none;
		}
		.italic {
		    font-style: italic;
		}
		.leading-3 {
		    line-height: .75rem;
		}
		.leading-5 {
		    line-height: 1.25rem;
		}
		.leading-6 {
		    line-height: 1.5rem;
		}
		.leading-8 {
		    line-height: 2rem;
		}
		.leading-\[2\.15rem\] {
		    line-height: 2.15rem;
		}
		.leading-none {
		    line-height: 1;
		}
		.leading-relaxed {
		    line-height: 1.625;
		}
		.leading-tight {
		    line-height: 1.25;
		}
		.text-danger {
		    --tw-text-opacity: 1;
		    color: rgb(var(--color-danger) / var(--tw-text-opacity));
		}
		.text-dark {
		    --tw-text-opacity: 1;
		    color: rgb(var(--color-dark) / var(--tw-text-opacity));
		}
		.text-gray-600 {
		    --tw-text-opacity: 1;
		    color: rgb(75 85 99 / var(--tw-text-opacity));
		}
		.text-pending {
		    --tw-text-opacity: 1;
		    color: rgb(var(--color-pending) / var(--tw-text-opacity));
		}
		.text-primary {
		    --tw-text-opacity: 1;
		    color: rgb(var(--color-primary) / var(--tw-text-opacity));
		}
		.text-primary\/80 {
		    color: rgb(var(--color-primary) / 0.8);
		}
		.text-slate-300 {
		    --tw-text-opacity: 1;
		    color: rgb(203 213 225 / var(--tw-text-opacity));
		}
		.text-slate-400 {
		    --tw-text-opacity: 1;
		    color: rgb(148 163 184 / var(--tw-text-opacity));
		}
		.text-slate-500 {
		    --tw-text-opacity: 1;
		    color: rgb(100 116 139 / var(--tw-text-opacity));
		}
		.text-slate-600 {
		    --tw-text-opacity: 1;
		    color: rgb(71 85 105 / var(--tw-text-opacity));
		}
		.text-slate-700 {
		    --tw-text-opacity: 1;
		    color: rgb(51 65 85 / var(--tw-text-opacity));
		}
		.text-slate-800 {
		    --tw-text-opacity: 1;
		    color: rgb(30 41 59 / var(--tw-text-opacity));
		}
		.text-slate-900 {
		    --tw-text-opacity: 1;
		    color: rgb(15 23 42 / var(--tw-text-opacity));
		}
		.text-success {
		    --tw-text-opacity: 1;
		    color: rgb(var(--color-success) / var(--tw-text-opacity));
		}
		.text-warning {
		    --tw-text-opacity: 1;
		    color: rgb(var(--color-warning) / var(--tw-text-opacity));
		}
		.text-warning\/80 {
		    color: rgb(var(--color-warning) / 0.8);
		}
		.text-white {
		    --tw-text-opacity: 1;
		    color: rgb(255 255 255 / var(--tw-text-opacity));
		}
		.text-white\/70 {
		    color: rgb(255 255 255 / 0.7);
		}
		.text-white\/90 {
		    color: rgb(255 255 255 / 0.9);
		}
		.text-black {
		    --tw-text-opacity: 1;
		    color: rgb(0 0 0 / var(--tw-text-opacity));
		}
		.text-opacity-70 {
		    --tw-text-opacity: 0.7;
		}
		.text-opacity-80 {
		    --tw-text-opacity: 0.8;
		}
		.underline {
		    text-decoration-line: underline;
		}
		.decoration-dotted {
		    text-decoration-style: dotted;
		}
		.underline-offset-4 {
		    text-underline-offset: 4px;
		}
		.opacity-0 {
		    opacity: 0;
		}
		.opacity-100 {
		    opacity: 1;
		}
		.shadow-\[0px_0px_0px_2px_\#fff\2c _1px_1px_5px_rgba\(0\2c 0\2c 0\2c 0\.32\)\] {
		    --tw-shadow: 0px 0px 0px 2px #fff, 1px 1px 5px rgba(0,0,0,0.32);
		    --tw-shadow-colored: 0px 0px 0px 2px var(--tw-shadow-color), 1px 1px 5px var(--tw-shadow-color);
		    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
		}
		.shadow-\[0px_3px_10px_\#00000017\] {
		    --tw-shadow: 0px 3px 10px #00000017;
		    --tw-shadow-colored: 0px 3px 10px var(--tw-shadow-color);
		    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
		}
		.shadow-\[0px_3px_20px_\#0000000b\] {
		    --tw-shadow: 0px 3px 20px #0000000b;
		    --tw-shadow-colored: 0px 3px 20px var(--tw-shadow-color);
		    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
		}
		.shadow-\[5px_3px_5px_\#00000005\] {
		    --tw-shadow: 5px 3px 5px #00000005;
		    --tw-shadow-colored: 5px 3px 5px var(--tw-shadow-color);
		    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
		}
		.shadow-lg {
		    --tw-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
		    --tw-shadow-colored: 0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color);
		    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
		}
		.shadow-md {
		    --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
		    --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color);
		    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
		}
		.shadow-none {
		    --tw-shadow: 0 0 #0000;
		    --tw-shadow-colored: 0 0 #0000;
		    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
		}
		.shadow-sm {
		    --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
		    --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
		    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
		}
		.shadow-xl {
		    --tw-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
		    --tw-shadow-colored: 0 20px 25px -5px var(--tw-shadow-color), 0 8px 10px -6px var(--tw-shadow-color);
		    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
		}
		.shadow-\[0px_0px_0px_2px_\#fff\2c _1px_1px_5px_rgba\(250\2c 0\2c 0\2c 0\.32\)\] {
		    --tw-shadow: 0px 0px 0px 2px #fff, 1px 1px 5px rgba(250,0,0,0.32);
		    --tw-shadow-colored: 0px 0px 0px 2px var(--tw-shadow-color), 1px 1px 5px var(--tw-shadow-color);
		    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
		}
		.shadow-\[0px_0px_0px_2px_\#fff\2c _1px_1px_5px_rgba\(2\2c 0\2c 0\2c 0\.32\)\] {
		    --tw-shadow: 0px 0px 0px 2px #fff, 1px 1px 5px rgba(2,0,0,0.32);
		    --tw-shadow-colored: 0px 0px 0px 2px var(--tw-shadow-color), 1px 1px 5px var(--tw-shadow-color);
		    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
		}
		.outline-none {
		    outline: 2px solid transparent;
		    outline-offset: 2px;
		}
		.outline-danger {
		    outline-color: rgb(var(--color-danger) / 1);
		}
		.outline-dark {
		    outline-color: rgb(var(--color-dark) / 1);
		}
		.outline-pending {
		    outline-color: rgb(var(--color-pending) / 1);
		}
		.outline-primary {
		    outline-color: rgb(var(--color-primary) / 1);
		}
		.outline-secondary {
		    outline-color: rgb(var(--color-secondary) / 1);
		}
		.outline-success {
		    outline-color: rgb(var(--color-success) / 1);
		}
		.outline-warning {
		    outline-color: rgb(var(--color-warning) / 1);
		}
		.blur {
		    --tw-blur: blur(8px);
		    filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);
		}
		.filter {
		    filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);
		}
		.transition {
		    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, -webkit-backdrop-filter;
		    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
		    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter, -webkit-backdrop-filter;
		    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
		    transition-duration: 150ms;
		}
		.transition-\[width\] {
		    transition-property: width;
		    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
		    transition-duration: 150ms;
		}
		.transition-all {
		    transition-property: all;
		    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
		    transition-duration: 150ms;
		}
		.transition-opacity {
		    transition-property: opacity;
		    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
		    transition-duration: 150ms;
		}
		.transition-transform {
		    transition-property: transform;
		    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
		    transition-duration: 150ms;
		}
		.duration-100 {
		    transition-duration: 100ms;
		}
		.duration-150 {
		    transition-duration: 150ms;
		}
		.duration-200 {
		    transition-duration: 200ms;
		}
		.duration-300 {
		    transition-duration: 300ms;
		}
		.duration-500 {
		    transition-duration: 500ms;
		}
		.duration-\[400ms\] {
		    transition-duration: 400ms;
		}
		.ease-in-out {
		    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
		}
		.ease-linear {
		    transition-timing-function: linear;
		}
		.before\:box::before {
		    content: var(--tw-content);
		    box-shadow: 0px 3px 5px #0000000b;
		    background-color: white;
		    border: 1px solid #e2e8f0;
		    border-radius: 0.6rem;
		    position: relative;
		  }
		.dark .before\:box::before {
		      content: var(--tw-content);
		      background-color: rgb(var(--color-darkmode-600) / 1);
		      border-color: rgb(var(--color-darkmode-500) / 1);
		    }
		.placeholder\:text-slate-400\/90::-moz-placeholder {
		    color: rgb(148 163 184 / 0.9);
		}
		.placeholder\:text-slate-400\/90::placeholder {
		    color: rgb(148 163 184 / 0.9);
		}
		.before\:invisible::before {
		    content: var(--tw-content);
		    visibility: hidden;
		}
		.before\:fixed::before {
		    content: var(--tw-content);
		    position: fixed;
		}
		.before\:absolute::before {
		    content: var(--tw-content);
		    position: absolute;
		}
		.before\:inset-0::before {
		    content: var(--tw-content);
		    inset: 0px;
		}
		.before\:inset-x-0::before {
		    content: var(--tw-content);
		    left: 0px;
		    right: 0px;
		}
		.before\:inset-x-3::before {
		    content: var(--tw-content);
		    left: 0.75rem;
		    right: 0.75rem;
		}
		.before\:inset-y-0::before {
		    content: var(--tw-content);
		    top: 0px;
		    bottom: 0px;
		}
		.before\:bottom-0::before {
		    content: var(--tw-content);
		    bottom: 0px;
		}
		.before\:left-0::before {
		    content: var(--tw-content);
		    left: 0px;
		}
		.before\:right-0::before {
		    content: var(--tw-content);
		    right: 0px;
		}
		.before\:top-0::before {
		    content: var(--tw-content);
		    top: 0px;
		}
		.before\:top-\[-2px\]::before {
		    content: var(--tw-content);
		    top: -2px;
		}
		.before\:z-10::before {
		    content: var(--tw-content);
		    z-index: 10;
		}
		.before\:z-\[-1\]::before {
		    content: var(--tw-content);
		    z-index: -1;
		}
		.before\:mx-7::before {
		    content: var(--tw-content);
		    margin-left: 1.75rem;
		    margin-right: 1.75rem;
		}
		.before\:mx-auto::before {
		    content: var(--tw-content);
		    margin-left: auto;
		    margin-right: auto;
		}
		.before\:my-auto::before {
		    content: var(--tw-content);
		    margin-top: auto;
		    margin-bottom: auto;
		}
		.before\:-mb-\[16\%\]::before {
		    content: var(--tw-content);
		    margin-bottom: -16%;
		}
		.before\:-ml-\[1\.125rem\]::before {
		    content: var(--tw-content);
		    margin-left: -1.125rem;
		}
		.before\:-ml-\[13\%\]::before {
		    content: var(--tw-content);
		    margin-left: -13%;
		}
		.before\:-mt-4::before {
		    content: var(--tw-content);
		    margin-top: -1rem;
		}
		.before\:-mt-\[28\%\]::before {
		    content: var(--tw-content);
		    margin-top: -28%;
		}
		.before\:mb-7::before {
		    content: var(--tw-content);
		    margin-bottom: 1.75rem;
		}
		.before\:ml-10::before {
		    content: var(--tw-content);
		    margin-left: 2.5rem;
		}
		.before\:ml-5::before {
		    content: var(--tw-content);
		    margin-left: 1.25rem;
		}
		.before\:mt-3::before {
		    content: var(--tw-content);
		    margin-top: 0.75rem;
		}
		.before\:mt-4::before {
		    content: var(--tw-content);
		    margin-top: 1rem;
		}
		.before\:mt-5::before {
		    content: var(--tw-content);
		    margin-top: 1.25rem;
		}
		.before\:block::before {
		    content: var(--tw-content);
		    display: block;
		}
		.before\:hidden::before {
		    content: var(--tw-content);
		    display: none;
		}
		.before\:h-4::before {
		    content: var(--tw-content);
		    height: 1rem;
		}
		.before\:h-8::before {
		    content: var(--tw-content);
		    height: 2rem;
		}
		.before\:h-\[14px\]::before {
		    content: var(--tw-content);
		    height: 14px;
		}
		.before\:h-\[20px\]::before {
		    content: var(--tw-content);
		    height: 20px;
		}
		.before\:h-\[3px\]::before {
		    content: var(--tw-content);
		    height: 3px;
		}
		.before\:h-\[65px\]::before {
		    content: var(--tw-content);
		    height: 65px;
		}
		.before\:h-\[85\%\]::before {
		    content: var(--tw-content);
		    height: 85%;
		}
		.before\:h-\[8px\]::before {
		    content: var(--tw-content);
		    height: 8px;
		}
		.before\:h-full::before {
		    content: var(--tw-content);
		    height: 100%;
		}
		.before\:h-px::before {
		    content: var(--tw-content);
		    height: 1px;
		}
		.before\:h-screen::before {
		    content: var(--tw-content);
		    height: 100vh;
		}
		.before\:w-16::before {
		    content: var(--tw-content);
		    width: 4rem;
		}
		.before\:w-20::before {
		    content: var(--tw-content);
		    width: 5rem;
		}
		.before\:w-4::before {
		    content: var(--tw-content);
		    width: 1rem;
		}
		.before\:w-\[14px\]::before {
		    content: var(--tw-content);
		    width: 14px;
		}
		.before\:w-\[20px\]::before {
		    content: var(--tw-content);
		    width: 20px;
		}
		.before\:w-\[2px\]::before {
		    content: var(--tw-content);
		    width: 2px;
		}
		.before\:w-\[57\%\]::before {
		    content: var(--tw-content);
		    width: 57%;
		}
		.before\:w-\[69\%\]::before {
		    content: var(--tw-content);
		    width: 69%;
		}
		.before\:w-\[8px\]::before {
		    content: var(--tw-content);
		    width: 8px;
		}
		.before\:w-\[95\%\]::before {
		    content: var(--tw-content);
		    width: 95%;
		}
		.before\:w-full::before {
		    content: var(--tw-content);
		    width: 100%;
		}
		.before\:w-px::before {
		    content: var(--tw-content);
		    width: 1px;
		}
		.before\:translate-y-\[35px\]::before {
		    content: var(--tw-content);
		    --tw-translate-y: 35px;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.before\:rotate-\[-4\.5deg\]::before {
		    content: var(--tw-content);
		    --tw-rotate: -4.5deg;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.before\:rotate-\[-90deg\]::before {
		    content: var(--tw-content);
		    --tw-rotate: -90deg;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.before\:transform::before {
		    content: var(--tw-content);
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.before\:rounded-\[1\.3rem\]::before {
		    content: var(--tw-content);
		    border-radius: 1.3rem;
		}
		.before\:rounded-\[100\%\]::before {
		    content: var(--tw-content);
		    border-radius: 100%;
		}
		.before\:rounded-\[30px_30px_0px_0px\]::before {
		    content: var(--tw-content);
		    border-radius: 30px 30px 0px 0px;
		}
		.before\:rounded-full::before {
		    content: var(--tw-content);
		    border-radius: 9999px;
		}
		.before\:rounded-md::before {
		    content: var(--tw-content);
		    border-radius: 0.375rem;
		}
		.before\:rounded-xl::before {
		    content: var(--tw-content);
		    border-radius: 0.75rem;
		}
		.before\:rounded-b-\[30px\]::before {
		    content: var(--tw-content);
		    border-bottom-right-radius: 30px;
		    border-bottom-left-radius: 30px;
		}
		.before\:rounded-t-\[30px\]::before {
		    content: var(--tw-content);
		    border-top-left-radius: 30px;
		    border-top-right-radius: 30px;
		}
		.before\:rounded-bl::before {
		    content: var(--tw-content);
		    border-bottom-left-radius: 0.25rem;
		}
		.before\:bg-black::before {
		    content: var(--tw-content);
		    --tw-bg-opacity: 1;
		    background-color: rgb(0 0 0 / var(--tw-bg-opacity));
		}
		.before\:bg-black\/90::before {
		    content: var(--tw-content);
		    background-color: rgb(0 0 0 / 0.9);
		}
		.before\:bg-black\/\[0\.15\]::before {
		    content: var(--tw-content);
		    background-color: rgb(0 0 0 / 0.15);
		}
		.before\:bg-danger::before {
		    content: var(--tw-content);
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-danger) / var(--tw-bg-opacity));
		}
		.before\:bg-primary\/20::before {
		    content: var(--tw-content);
		    background-color: rgb(var(--color-primary) / 0.2);
		}
		.before\:bg-primary\/30::before {
		    content: var(--tw-content);
		    background-color: rgb(var(--color-primary) / 0.3);
		}
		.before\:bg-slate-100::before {
		    content: var(--tw-content);
		    --tw-bg-opacity: 1;
		    background-color: rgb(241 245 249 / var(--tw-bg-opacity));
		}
		.before\:bg-slate-200::before {
		    content: var(--tw-content);
		    --tw-bg-opacity: 1;
		    background-color: rgb(226 232 240 / var(--tw-bg-opacity));
		}
		.before\:bg-slate-200\/70::before {
		    content: var(--tw-content);
		    background-color: rgb(226 232 240 / 0.7);
		}
		.before\:bg-slate-50::before {
		    content: var(--tw-content);
		    --tw-bg-opacity: 1;
		    background-color: rgb(248 250 252 / var(--tw-bg-opacity));
		}
		.before\:bg-transparent::before {
		    content: var(--tw-content);
		    background-color: transparent;
		}
		.before\:bg-white\/10::before {
		    content: var(--tw-content);
		    background-color: rgb(255 255 255 / 0.1);
		}
		.before\:bg-opacity-70::before {
		    content: var(--tw-content);
		    --tw-bg-opacity: 0.7;
		}
		.before\:bg-chevron-black::before {
		    content: var(--tw-content);
		    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%2300000095' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
		}
		.before\:bg-chevron-white::before {
		    content: var(--tw-content);
		    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23ffffff95' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
		}
		.before\:bg-gradient-to-b::before {
		    content: var(--tw-content);
		    background-image: linear-gradient(to bottom, var(--tw-gradient-stops));
		}
		.before\:bg-gradient-to-r::before {
		    content: var(--tw-content);
		    background-image: linear-gradient(to right, var(--tw-gradient-stops));
		}
		.before\:bg-gradient-to-t::before {
		    content: var(--tw-content);
		    background-image: linear-gradient(to top, var(--tw-gradient-stops));
		}
		.before\:from-black::before {
		    content: var(--tw-content);
		    --tw-gradient-from: #000 var(--tw-gradient-from-position);
		    --tw-gradient-to: rgb(0 0 0 / 0) var(--tw-gradient-to-position);
		    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
		}
		.before\:from-black\/90::before {
		    content: var(--tw-content);
		    --tw-gradient-from: rgb(0 0 0 / 0.9) var(--tw-gradient-from-position);
		    --tw-gradient-to: rgb(0 0 0 / 0) var(--tw-gradient-to-position);
		    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
		}
		.before\:from-theme-1::before {
		    content: var(--tw-content);
		    --tw-gradient-from: rgb(var(--color-theme-1) / 1) var(--tw-gradient-from-position);
		    --tw-gradient-to: rgb(var(--color-theme-1) / 0) var(--tw-gradient-to-position);
		    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
		}
		.before\:from-white::before {
		    content: var(--tw-content);
		    --tw-gradient-from: #fff var(--tw-gradient-from-position);
		    --tw-gradient-to: rgb(255 255 255 / 0) var(--tw-gradient-to-position);
		    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
		}
		.before\:via-white\/80::before {
		    content: var(--tw-content);
		    --tw-gradient-to: rgb(255 255 255 / 0)  var(--tw-gradient-to-position);
		    --tw-gradient-stops: var(--tw-gradient-from), rgb(255 255 255 / 0.8) var(--tw-gradient-via-position), var(--tw-gradient-to);
		}
		.before\:to-black\/10::before {
		    content: var(--tw-content);
		    --tw-gradient-to: rgb(0 0 0 / 0.1) var(--tw-gradient-to-position);
		}
		.before\:to-theme-2::before {
		    content: var(--tw-content);
		    --tw-gradient-to: rgb(var(--color-theme-2) / 1) var(--tw-gradient-to-position);
		}
		.before\:to-transparent::before {
		    content: var(--tw-content);
		    --tw-gradient-to: transparent var(--tw-gradient-to-position);
		}
		.before\:bg-\[length\:100\%\]::before {
		    content: var(--tw-content);
		    background-size: 100%;
		}
		.before\:px-4::before {
		    content: var(--tw-content);
		    padding-left: 1rem;
		    padding-right: 1rem;
		}
		.before\:py-2::before {
		    content: var(--tw-content);
		    padding-top: 0.5rem;
		    padding-bottom: 0.5rem;
		}
		.before\:pt-\[100\%\]::before {
		    content: var(--tw-content);
		    padding-top: 100%;
		}
		.before\:font-roboto::before {
		    content: var(--tw-content);
		    font-family: Roboto;
		}
		.before\:font-medium::before {
		    content: var(--tw-content);
		    font-weight: 500;
		}
		.before\:opacity-0::before {
		    content: var(--tw-content);
		    opacity: 0;
		}
		.before\:shadow-\[1px_1px_3px_rgba\(0\2c 0\2c 0\2c 0\.25\)\]::before {
		    content: var(--tw-content);
		    --tw-shadow: 1px 1px 3px rgba(0,0,0,0.25);
		    --tw-shadow-colored: 1px 1px 3px var(--tw-shadow-color);
		    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
		}
		.before\:transition-\[margin-left\]::before {
		    content: var(--tw-content);
		    transition-property: margin-left;
		    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
		    transition-duration: 150ms;
		}
		.before\:transition-opacity::before {
		    content: var(--tw-content);
		    transition-property: opacity;
		    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
		    transition-duration: 150ms;
		}
		.before\:duration-200::before {
		    content: var(--tw-content);
		    transition-duration: 200ms;
		}
		.before\:ease-in-out::before {
		    content: var(--tw-content);
		    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
		}
		.before\:content-\[\'\'\]::before {
		    --tw-content: '';
		    content: var(--tw-content);
		}
		.before\:content-\[\'HTML\'\]::before {
		    --tw-content: 'HTML';
		    content: var(--tw-content);
		}
		.before\:content-\[\\\'\\\'\]::before {
		    --tw-content: \'\';
		    content: var(--tw-content);
		}
		.after\:fixed::after {
		    content: var(--tw-content);
		    position: fixed;
		}
		.after\:absolute::after {
		    content: var(--tw-content);
		    position: absolute;
		}
		.after\:inset-0::after {
		    content: var(--tw-content);
		    inset: 0px;
		}
		.after\:inset-y-0::after {
		    content: var(--tw-content);
		    top: 0px;
		    bottom: 0px;
		}
		.after\:bottom-0::after {
		    content: var(--tw-content);
		    bottom: 0px;
		}
		.after\:left-0::after {
		    content: var(--tw-content);
		    left: 0px;
		}
		.after\:right-0::after {
		    content: var(--tw-content);
		    right: 0px;
		}
		.after\:top-0::after {
		    content: var(--tw-content);
		    top: 0px;
		}
		.after\:z-\[-1\]::after {
		    content: var(--tw-content);
		    z-index: -1;
		}
		.after\:z-\[-2\]::after {
		    content: var(--tw-content);
		    z-index: -2;
		}
		.after\:mx-3::after {
		    content: var(--tw-content);
		    margin-left: 0.75rem;
		    margin-right: 0.75rem;
		}
		.after\:mx-auto::after {
		    content: var(--tw-content);
		    margin-left: auto;
		    margin-right: auto;
		}
		.after\:-mb-\[13\%\]::after {
		    content: var(--tw-content);
		    margin-bottom: -13%;
		}
		.after\:-ml-4::after {
		    content: var(--tw-content);
		    margin-left: -1rem;
		}
		.after\:-ml-\[13\%\]::after {
		    content: var(--tw-content);
		    margin-left: -13%;
		}
		.after\:-mt-4::after {
		    content: var(--tw-content);
		    margin-top: -1rem;
		}
		.after\:-mt-\[20\%\]::after {
		    content: var(--tw-content);
		    margin-top: -20%;
		}
		.after\:mb-7::after {
		    content: var(--tw-content);
		    margin-bottom: 1.75rem;
		}
		.after\:mt-5::after {
		    content: var(--tw-content);
		    margin-top: 1.25rem;
		}
		.after\:mt-8::after {
		    content: var(--tw-content);
		    margin-top: 2rem;
		}
		.after\:block::after {
		    content: var(--tw-content);
		    display: block;
		}
		.after\:hidden::after {
		    content: var(--tw-content);
		    display: none;
		}
		.after\:h-4::after {
		    content: var(--tw-content);
		    height: 1rem;
		}
		.after\:h-\[65px\]::after {
		    content: var(--tw-content);
		    height: 65px;
		}
		.after\:w-16::after {
		    content: var(--tw-content);
		    width: 4rem;
		}
		.after\:w-4::after {
		    content: var(--tw-content);
		    width: 1rem;
		}
		.after\:w-\[57\%\]::after {
		    content: var(--tw-content);
		    width: 57%;
		}
		.after\:w-\[97\%\]::after {
		    content: var(--tw-content);
		    width: 97%;
		}
		.after\:w-full::after {
		    content: var(--tw-content);
		    width: 100%;
		}
		.after\:rotate-\[-4\.5deg\]::after {
		    content: var(--tw-content);
		    --tw-rotate: -4.5deg;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.after\:transform::after {
		    content: var(--tw-content);
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.after\:rounded-\[100\%\]::after {
		    content: var(--tw-content);
		    border-radius: 100%;
		}
		.after\:rounded-\[40px_0px_0px_0px\]::after {
		    content: var(--tw-content);
		    border-radius: 40px 0px 0px 0px;
		}
		.after\:rounded-\[40px_40px_0px_0px\]::after {
		    content: var(--tw-content);
		    border-radius: 40px 40px 0px 0px;
		}
		.after\:rounded-full::after {
		    content: var(--tw-content);
		    border-radius: 9999px;
		}
		.after\:rounded-xl::after {
		    content: var(--tw-content);
		    border-radius: 0.75rem;
		}
		.after\:border-4::after {
		    content: var(--tw-content);
		    border-width: 4px;
		}
		.after\:border-white\/60::after {
		    content: var(--tw-content);
		    border-color: rgb(255 255 255 / 0.6);
		}
		.after\:bg-primary::after {
		    content: var(--tw-content);
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-primary) / var(--tw-bg-opacity));
		}
		.after\:bg-white\/10::after {
		    content: var(--tw-content);
		    background-color: rgb(255 255 255 / 0.1);
		}
		.after\:bg-gradient-to-b::after {
		    content: var(--tw-content);
		    background-image: linear-gradient(to bottom, var(--tw-gradient-stops));
		}
		.after\:bg-gradient-to-l::after {
		    content: var(--tw-content);
		    background-image: linear-gradient(to left, var(--tw-gradient-stops));
		}
		.after\:from-theme-1::after {
		    content: var(--tw-content);
		    --tw-gradient-from: rgb(var(--color-theme-1) / 1) var(--tw-gradient-from-position);
		    --tw-gradient-to: rgb(var(--color-theme-1) / 0) var(--tw-gradient-to-position);
		    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
		}
		.after\:from-white::after {
		    content: var(--tw-content);
		    --tw-gradient-from: #fff var(--tw-gradient-from-position);
		    --tw-gradient-to: rgb(255 255 255 / 0) var(--tw-gradient-to-position);
		    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
		}
		.after\:via-white\/80::after {
		    content: var(--tw-content);
		    --tw-gradient-to: rgb(255 255 255 / 0)  var(--tw-gradient-to-position);
		    --tw-gradient-stops: var(--tw-gradient-from), rgb(255 255 255 / 0.8) var(--tw-gradient-via-position), var(--tw-gradient-to);
		}
		.after\:to-theme-2::after {
		    content: var(--tw-content);
		    --tw-gradient-to: rgb(var(--color-theme-2) / 1) var(--tw-gradient-to-position);
		}
		.after\:to-transparent::after {
		    content: var(--tw-content);
		    --tw-gradient-to: transparent var(--tw-gradient-to-position);
		}
		.after\:shadow-md::after {
		    content: var(--tw-content);
		    --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
		    --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color);
		    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
		}
		.after\:content-\[\'\'\]::after {
		    --tw-content: '';
		    content: var(--tw-content);
		}
		.after\:content-\[\\\'\\\'\]::after {
		    --tw-content: \'\';
		    content: var(--tw-content);
		}
		.first\:-mt-4:first-child {
		    margin-top: -1rem;
		}
		.first\:mt-0:first-child {
		    margin-top: 0px;
		}
		.first\:rounded-l:first-child {
		    border-top-left-radius: 0.25rem;
		    border-bottom-left-radius: 0.25rem;
		}
		.first\:rounded-l-\[0\.6rem\]:first-child {
		    border-top-left-radius: 0.6rem;
		    border-bottom-left-radius: 0.6rem;
		}
		.first\:border-l:first-child {
		    border-left-width: 1px;
		}
		.first\:pt-0:first-child {
		    padding-top: 0px;
		}
		.last\:-mb-4:last-child {
		    margin-bottom: -1rem;
		}
		.last\:mb-0:last-child {
		    margin-bottom: 0px;
		}
		.last\:rounded-r:last-child {
		    border-top-right-radius: 0.25rem;
		    border-bottom-right-radius: 0.25rem;
		}
		.last\:rounded-r-\[0\.6rem\]:last-child {
		    border-top-right-radius: 0.6rem;
		    border-bottom-right-radius: 0.6rem;
		}
		.last\:border-r:last-child {
		    border-right-width: 1px;
		}
		.checked\:border-primary:checked {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-primary) / var(--tw-border-opacity));
		}
		.checked\:bg-primary:checked {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-primary) / var(--tw-bg-opacity));
		}
		.checked\:bg-none:checked {
		    background-image: none;
		}
		.before\:checked\:ml-\[14px\]:checked::before {
		    content: var(--tw-content);
		    margin-left: 14px;
		}
		.before\:checked\:bg-white:checked::before {
		    content: var(--tw-content);
		    --tw-bg-opacity: 1;
		    background-color: rgb(255 255 255 / var(--tw-bg-opacity));
		}
		.hover\:relative:hover {
		    position: relative;
		}
		.hover\:z-20:hover {
		    z-index: 20;
		}
		.hover\:rotate-180:hover {
		    --tw-rotate: 180deg;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.hover\:scale-105:hover {
		    --tw-scale-x: 1.05;
		    --tw-scale-y: 1.05;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.hover\:scale-\[1\.02\]:hover {
		    --tw-scale-x: 1.02;
		    --tw-scale-y: 1.02;
		    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
		}
		.hover\:rounded:hover {
		    border-radius: 0.25rem;
		}
		.hover\:border-0:hover {
		    border-width: 0px;
		}
		.hover\:border-transparent:hover {
		    border-color: transparent;
		}
		.hover\:bg-slate-100:hover {
		    --tw-bg-opacity: 1;
		    background-color: rgb(241 245 249 / var(--tw-bg-opacity));
		}
		.hover\:bg-slate-200:hover {
		    --tw-bg-opacity: 1;
		    background-color: rgb(226 232 240 / var(--tw-bg-opacity));
		}
		.hover\:bg-slate-200\/60:hover {
		    background-color: rgb(226 232 240 / 0.6);
		}
		.hover\:bg-transparent:hover {
		    background-color: transparent;
		}
		.hover\:bg-white\/10:hover {
		    background-color: rgb(255 255 255 / 0.1);
		}
		.hover\:bg-white\/5:hover {
		    background-color: rgb(255 255 255 / 0.05);
		}
		.hover\:bg-opacity-30:hover {
		    --tw-bg-opacity: 0.3;
		}
		.hover\:text-slate-600:hover {
		    --tw-text-opacity: 1;
		    color: rgb(71 85 105 / var(--tw-text-opacity));
		}
		.hover\:shadow-md:hover {
		    --tw-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
		    --tw-shadow-colored: 0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color);
		    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
		}
		.focus\:w-72:focus {
		    width: 18rem;
		}
		.focus\:border-primary:focus {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-primary) / var(--tw-border-opacity));
		}
		.focus\:border-transparent:focus {
		    border-color: transparent;
		}
		.focus\:border-opacity-40:focus {
		    --tw-border-opacity: 0.4;
		}
		.focus\:outline-none:focus {
		    outline: 2px solid transparent;
		    outline-offset: 2px;
		}
		.focus\:ring-0:focus {
		    --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
		    --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(0px + var(--tw-ring-offset-width)) var(--tw-ring-color);
		    box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
		}
		.focus\:ring-4:focus {
		    --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
		    --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(4px + var(--tw-ring-offset-width)) var(--tw-ring-color);
		    box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
		}
		.focus\:ring-primary:focus {
		    --tw-ring-opacity: 1;
		    --tw-ring-color: rgb(var(--color-primary) / var(--tw-ring-opacity));
		}
		.focus\:ring-opacity-20:focus {
		    --tw-ring-opacity: 0.2;
		}
		.focus\:ring-offset-0:focus {
		    --tw-ring-offset-width: 0px;
		}
		.focus-visible\:outline-none:focus-visible {
		    outline: 2px solid transparent;
		    outline-offset: 2px;
		}
		.disabled\:cursor-not-allowed:disabled {
		    cursor: not-allowed;
		}
		.disabled\:bg-slate-100:disabled {
		    --tw-bg-opacity: 1;
		    background-color: rgb(241 245 249 / var(--tw-bg-opacity));
		}
		.disabled\:opacity-70:disabled {
		    opacity: 0.7;
		}
		.group.mobile-menu--active .group-\[\.mobile-menu--active\]\:visible {
		    visibility: visible;
		}
		.group.mobile-menu--active .group-\[\.mobile-menu--active\]\:ml-0 {
		    margin-left: 0px;
		}
		.group.mobile-menu--active .group-\[\.mobile-menu--active\]\:opacity-100 {
		    opacity: 1;
		}
		:is(.dark .dark\:border) {
		    border-width: 1px;
		}
		:is(.dark .dark\:border-0) {
		    border-width: 0px;
		}
		:is(.dark .dark\:border-\[\#0077b5\]) {
		    --tw-border-opacity: 1;
		    border-color: rgb(0 119 181 / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-\[\#3b5998\]) {
		    --tw-border-opacity: 1;
		    border-color: rgb(59 89 152 / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-\[\#4ab3f4\]) {
		    --tw-border-opacity: 1;
		    border-color: rgb(74 179 244 / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-\[\#517fa4\]) {
		    --tw-border-opacity: 1;
		    border-color: rgb(81 127 164 / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-danger) {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-danger) / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-darkmode-100\/30) {
		    border-color: rgb(var(--color-darkmode-100) / 0.3);
		}
		:is(.dark .dark\:border-darkmode-100\/40) {
		    border-color: rgb(var(--color-darkmode-100) / 0.4);
		}
		:is(.dark .dark\:border-darkmode-300) {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-darkmode-300) / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-darkmode-400) {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-darkmode-400) / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-darkmode-500) {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-darkmode-500) / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-darkmode-600) {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-darkmode-600) / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-darkmode-800) {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-darkmode-800) / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-darkmode-800\/60) {
		    border-color: rgb(var(--color-darkmode-800) / 0.6);
		}
		:is(.dark .dark\:border-darkmode-900\/20) {
		    border-color: rgb(var(--color-darkmode-900) / 0.2);
		}
		:is(.dark .dark\:border-pending) {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-pending) / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-primary) {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-primary) / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-success) {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-success) / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-transparent) {
		    border-color: transparent;
		}
		:is(.dark .dark\:border-warning) {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-warning) / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-white\/\[0\.08\]) {
		    border-color: rgb(255 255 255 / 0.08);
		}
		:is(.dark .dark\:border-x-darkmode-400) {
		    --tw-border-opacity: 1;
		    border-left-color: rgb(var(--color-darkmode-400) / var(--tw-border-opacity));
		    border-right-color: rgb(var(--color-darkmode-400) / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-x-transparent) {
		    border-left-color: transparent;
		    border-right-color: transparent;
		}
		:is(.dark .dark\:border-b-darkmode-600) {
		    --tw-border-opacity: 1;
		    border-bottom-color: rgb(var(--color-darkmode-600) / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-b-primary) {
		    --tw-border-opacity: 1;
		    border-bottom-color: rgb(var(--color-primary) / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-t-darkmode-400) {
		    --tw-border-opacity: 1;
		    border-top-color: rgb(var(--color-darkmode-400) / var(--tw-border-opacity));
		}
		:is(.dark .dark\:border-t-transparent) {
		    border-top-color: transparent;
		}
		:is(.dark .dark\:border-opacity-100) {
		    --tw-border-opacity: 1;
		}
		:is(.dark .dark\:border-opacity-20) {
		    --tw-border-opacity: 0.2;
		}
		:is(.dark .dark\:bg-black\/10) {
		    background-color: rgb(0 0 0 / 0.1);
		}
		:is(.dark .dark\:bg-black\/20) {
		    background-color: rgb(0 0 0 / 0.2);
		}
		:is(.dark .dark\:bg-black\/30) {
		    background-color: rgb(0 0 0 / 0.3);
		}
		:is(.dark .dark\:bg-danger\/10) {
		    background-color: rgb(var(--color-danger) / 0.1);
		}
		:is(.dark .dark\:bg-dark) {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-dark) / var(--tw-bg-opacity));
		}
		:is(.dark .dark\:bg-darkmode-100\/20) {
		    background-color: rgb(var(--color-darkmode-100) / 0.2);
		}
		:is(.dark .dark\:bg-darkmode-300) {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-300) / var(--tw-bg-opacity));
		}
		:is(.dark .dark\:bg-darkmode-400) {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-400) / var(--tw-bg-opacity));
		}
		:is(.dark .dark\:bg-darkmode-400\/70) {
		    background-color: rgb(var(--color-darkmode-400) / 0.7);
		}
		:is(.dark .dark\:bg-darkmode-500) {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-500) / var(--tw-bg-opacity));
		}
		:is(.dark .dark\:bg-darkmode-600) {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-600) / var(--tw-bg-opacity));
		}
		:is(.dark .dark\:bg-darkmode-700) {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-700) / var(--tw-bg-opacity));
		}
		:is(.dark .dark\:bg-darkmode-800) {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-800) / var(--tw-bg-opacity));
		}
		:is(.dark .dark\:bg-darkmode-800\/30) {
		    background-color: rgb(var(--color-darkmode-800) / 0.3);
		}
		:is(.dark .dark\:bg-darkmode-800\/90) {
		    background-color: rgb(var(--color-darkmode-800) / 0.9);
		}
		:is(.dark .dark\:bg-darkmode-900\/20) {
		    background-color: rgb(var(--color-darkmode-900) / 0.2);
		}
		:is(.dark .dark\:bg-pending\/10) {
		    background-color: rgb(var(--color-pending) / 0.1);
		}
		:is(.dark .dark\:bg-pending\/30) {
		    background-color: rgb(var(--color-pending) / 0.3);
		}
		:is(.dark .dark\:bg-primary) {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-primary) / var(--tw-bg-opacity));
		}
		:is(.dark .dark\:bg-primary\/20) {
		    background-color: rgb(var(--color-primary) / 0.2);
		}
		:is(.dark .dark\:bg-primary\/50) {
		    background-color: rgb(var(--color-primary) / 0.5);
		}
		:is(.dark .dark\:bg-slate-200) {
		    --tw-bg-opacity: 1;
		    background-color: rgb(226 232 240 / var(--tw-bg-opacity));
		}
		:is(.dark .dark\:bg-success\/10) {
		    background-color: rgb(var(--color-success) / 0.1);
		}
		:is(.dark .dark\:bg-success\/30) {
		    background-color: rgb(var(--color-success) / 0.3);
		}
		:is(.dark .dark\:bg-transparent) {
		    background-color: transparent;
		}
		:is(.dark .dark\:bg-warning\/10) {
		    background-color: rgb(var(--color-warning) / 0.1);
		}
		:is(.dark .dark\:bg-opacity-20) {
		    --tw-bg-opacity: 0.2;
		}
		:is(.dark .dark\:from-darkmode-400) {
		    --tw-gradient-from: rgb(var(--color-darkmode-400) / 1) var(--tw-gradient-from-position);
		    --tw-gradient-to: rgb(var(--color-darkmode-400) / 0) var(--tw-gradient-to-position);
		    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
		}
		:is(.dark .dark\:from-darkmode-800) {
		    --tw-gradient-from: rgb(var(--color-darkmode-800) / 1) var(--tw-gradient-from-position);
		    --tw-gradient-to: rgb(var(--color-darkmode-800) / 0) var(--tw-gradient-to-position);
		    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
		}
		:is(.dark .dark\:to-darkmode-400) {
		    --tw-gradient-to: rgb(var(--color-darkmode-400) / 1) var(--tw-gradient-to-position);
		}
		:is(.dark .dark\:to-darkmode-800) {
		    --tw-gradient-to: rgb(var(--color-darkmode-800) / 1) var(--tw-gradient-to-position);
		}
		:is(.dark .dark\:text-slate-200) {
		    --tw-text-opacity: 1;
		    color: rgb(226 232 240 / var(--tw-text-opacity));
		}
		:is(.dark .dark\:text-slate-300) {
		    --tw-text-opacity: 1;
		    color: rgb(203 213 225 / var(--tw-text-opacity));
		}
		:is(.dark .dark\:text-slate-400) {
		    --tw-text-opacity: 1;
		    color: rgb(148 163 184 / var(--tw-text-opacity));
		}
		:is(.dark .dark\:text-slate-500) {
		    --tw-text-opacity: 1;
		    color: rgb(100 116 139 / var(--tw-text-opacity));
		}
		:is(.dark .dark\:text-white) {
		    --tw-text-opacity: 1;
		    color: rgb(255 255 255 / var(--tw-text-opacity));
		}
		:is(.dark .dark\:shadow-\[0px_0px_0px_2px_\#3f4865\2c _1px_1px_5px_rgba\(0\2c 0\2c 0\2c 0\.32\)\]) {
		    --tw-shadow: 0px 0px 0px 2px #3f4865, 1px 1px 5px rgba(0,0,0,0.32);
		    --tw-shadow-colored: 0px 0px 0px 2px var(--tw-shadow-color), 1px 1px 5px var(--tw-shadow-color);
		    box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
		}
		:is(.dark .dark\:placeholder\:text-slate-500\/80)::-moz-placeholder {
		    color: rgb(100 116 139 / 0.8);
		}
		:is(.dark .dark\:placeholder\:text-slate-500\/80)::placeholder {
		    color: rgb(100 116 139 / 0.8);
		}
		:is(.dark .before\:dark\:bg-darkmode-400)::before {
		    content: var(--tw-content);
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-400) / var(--tw-bg-opacity));
		}
		:is(.dark .before\:dark\:bg-darkmode-400\/50)::before {
		    content: var(--tw-content);
		    background-color: rgb(var(--color-darkmode-400) / 0.5);
		}
		:is(.dark .before\:dark\:bg-darkmode-500)::before {
		    content: var(--tw-content);
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-500) / var(--tw-bg-opacity));
		}
		:is(.dark .before\:dark\:bg-darkmode-600)::before {
		    content: var(--tw-content);
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-600) / var(--tw-bg-opacity));
		}
		:is(.dark .before\:dark\:bg-darkmode-600\/30)::before {
		    content: var(--tw-content);
		    background-color: rgb(var(--color-darkmode-600) / 0.3);
		}
		:is(.dark .before\:dark\:bg-darkmode-700)::before {
		    content: var(--tw-content);
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-700) / var(--tw-bg-opacity));
		}
		:is(.dark .before\:dark\:bg-opacity-50)::before {
		    content: var(--tw-content);
		    --tw-bg-opacity: 0.5;
		}
		:is(.dark .dark\:before\:bg-chevron-white)::before {
		    content: var(--tw-content);
		    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23ffffff95' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
		}
		:is(.dark .before\:dark\:from-darkmode-600)::before {
		    content: var(--tw-content);
		    --tw-gradient-from: rgb(var(--color-darkmode-600) / 1) var(--tw-gradient-from-position);
		    --tw-gradient-to: rgb(var(--color-darkmode-600) / 0) var(--tw-gradient-to-position);
		    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
		}
		:is(.dark .dark\:before\:from-darkmode-800)::before {
		    content: var(--tw-content);
		    --tw-gradient-from: rgb(var(--color-darkmode-800) / 1) var(--tw-gradient-from-position);
		    --tw-gradient-to: rgb(var(--color-darkmode-800) / 0) var(--tw-gradient-to-position);
		    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
		}
		:is(.dark .dark\:before\:to-darkmode-800)::before {
		    content: var(--tw-content);
		    --tw-gradient-to: rgb(var(--color-darkmode-800) / 1) var(--tw-gradient-to-position);
		}
		:is(.dark .after\:dark\:border-darkmode-300)::after {
		    content: var(--tw-content);
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-darkmode-300) / var(--tw-border-opacity));
		}
		:is(.dark .after\:dark\:bg-darkmode-400\/50)::after {
		    content: var(--tw-content);
		    background-color: rgb(var(--color-darkmode-400) / 0.5);
		}
		:is(.dark .after\:dark\:bg-darkmode-600)::after {
		    content: var(--tw-content);
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-600) / var(--tw-bg-opacity));
		}
		:is(.dark .after\:dark\:bg-darkmode-700)::after {
		    content: var(--tw-content);
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-700) / var(--tw-bg-opacity));
		}
		:is(.dark .after\:dark\:from-darkmode-600)::after {
		    content: var(--tw-content);
		    --tw-gradient-from: rgb(var(--color-darkmode-600) / 1) var(--tw-gradient-from-position);
		    --tw-gradient-to: rgb(var(--color-darkmode-600) / 0) var(--tw-gradient-to-position);
		    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
		}
		:is(.dark .dark\:after\:from-darkmode-800)::after {
		    content: var(--tw-content);
		    --tw-gradient-from: rgb(var(--color-darkmode-800) / 1) var(--tw-gradient-from-position);
		    --tw-gradient-to: rgb(var(--color-darkmode-800) / 0) var(--tw-gradient-to-position);
		    --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
		}
		:is(.dark .dark\:after\:to-darkmode-800)::after {
		    content: var(--tw-content);
		    --tw-gradient-to: rgb(var(--color-darkmode-800) / 1) var(--tw-gradient-to-position);
		}
		:is(.dark .dark\:hover\:border-transparent:hover) {
		    border-color: transparent;
		}
		:is(.dark .dark\:hover\:bg-darkmode-400:hover) {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-400) / var(--tw-bg-opacity));
		}
		:is(.dark .hover\:dark\:bg-transparent):hover {
		    background-color: transparent;
		}
		:is(.dark .hover\:dark\:text-slate-300):hover {
		    --tw-text-opacity: 1;
		    color: rgb(203 213 225 / var(--tw-text-opacity));
		}
		:is(.dark .dark\:focus\:ring-slate-700:focus) {
		    --tw-ring-opacity: 1;
		    --tw-ring-color: rgb(51 65 85 / var(--tw-ring-opacity));
		}
		:is(.dark .dark\:focus\:ring-opacity-50:focus) {
		    --tw-ring-opacity: 0.5;
		}
		:is(.dark .dark\:disabled\:border-transparent:disabled) {
		    border-color: transparent;
		}
		:is(.dark .dark\:disabled\:bg-darkmode-800\/50:disabled) {
		    background-color: rgb(var(--color-darkmode-800) / 0.5);
		}
		:is(.dark .disabled\:dark\:bg-darkmode-800\/50):disabled {
		    background-color: rgb(var(--color-darkmode-800) / 0.5);
		}
		@media (min-width: 640px) {
		    .sm\:static {
		        position: static;
		    }
		    .sm\:absolute {
		        position: absolute;
		    }
		    .sm\:relative {
		        position: relative;
		    }
		    .sm\:col-span-1 {
		        grid-column: span 1 / span 1;
		    }
		    .sm\:col-span-3 {
		        grid-column: span 3 / span 3;
		    }
		    .sm\:col-span-4 {
		        grid-column: span 4 / span 4;
		    }
		    .sm\:col-span-6 {
		        grid-column: span 6 / span 6;
		    }
		    .sm\:col-span-12 {
		        grid-column: span 12 / span 12;
		    }
		    .sm\:-mx-8 {
		        margin-left: -2rem;
		        margin-right: -2rem;
		    }
		    .sm\:mx-0 {
		        margin-left: 0px;
		        margin-right: 0px;
		    }
		    .sm\:mx-2 {
		        margin-left: 0.5rem;
		        margin-right: 0.5rem;
		    }
		    .sm\:\!mr-10 {
		        margin-right: 2.5rem !important;
		    }
		    .sm\:-ml-\[105px\] {
		        margin-left: -105px;
		    }
		    .sm\:mb-0 {
		        margin-bottom: 0px;
		    }
		    .sm\:ml-0 {
		        margin-left: 0px;
		    }
		    .sm\:ml-1 {
		        margin-left: 0.25rem;
		    }
		    .sm\:ml-2 {
		        margin-left: 0.5rem;
		    }
		    .sm\:ml-20 {
		        margin-left: 5rem;
		    }
		    .sm\:ml-3 {
		        margin-left: 0.75rem;
		    }
		    .sm\:ml-40 {
		        margin-left: 10rem;
		    }
		    .sm\:ml-auto {
		        margin-left: auto;
		    }
		    .sm\:mr-0 {
		        margin-right: 0px;
		    }
		    .sm\:mr-2 {
		        margin-right: 0.5rem;
		    }
		    .sm\:mr-20 {
		        margin-right: 5rem;
		    }
		    .sm\:mr-28 {
		        margin-right: 7rem;
		    }
		    .sm\:mr-3 {
		        margin-right: 0.75rem;
		    }
		    .sm\:mr-4 {
		        margin-right: 1rem;
		    }
		    .sm\:mr-40 {
		        margin-right: 10rem;
		    }
		    .sm\:mr-5 {
		        margin-right: 1.25rem;
		    }
		    .sm\:mr-6 {
		        margin-right: 1.5rem;
		    }
		    .sm\:mr-auto {
		        margin-right: auto;
		    }
		    .sm\:mt-0 {
		        margin-top: 0px;
		    }
		    .sm\:mt-10 {
		        margin-top: 2.5rem;
		    }
		    .sm\:mt-2 {
		        margin-top: 0.5rem;
		    }
		    .sm\:mt-5 {
		        margin-top: 1.25rem;
		    }
		    .sm\:block {
		        display: block;
		    }
		    .sm\:flex {
		        display: flex;
		    }
		    .sm\:grid {
		        display: grid;
		    }
		    .sm\:hidden {
		        display: none;
		    }
		    .sm\:h-10 {
		        height: 2.5rem;
		    }
		    .sm\:h-12 {
		        height: 3rem;
		    }
		    .sm\:h-14 {
		        height: 3.5rem;
		    }
		    .sm\:h-24 {
		        height: 6rem;
		    }
		    .sm\:h-5 {
		        height: 1.25rem;
		    }
		    .sm\:h-8 {
		        height: 2rem;
		    }
		    .sm\:w-10 {
		        width: 2.5rem;
		    }
		    .sm\:w-12 {
		        width: 3rem;
		    }
		    .sm\:w-14 {
		        width: 3.5rem;
		    }
		    .sm\:w-16 {
		        width: 4rem;
		    }
		    .sm\:w-20 {
		        width: 5rem;
		    }
		    .sm\:w-24 {
		        width: 6rem;
		    }
		    .sm\:w-3\/4 {
		        width: 75%;
		    }
		    .sm\:w-32 {
		        width: 8rem;
		    }
		    .sm\:w-40 {
		        width: 10rem;
		    }
		    .sm\:w-5 {
		        width: 1.25rem;
		    }
		    .sm\:w-52 {
		        width: 13rem;
		    }
		    .sm\:w-56 {
		        width: 14rem;
		    }
		    .sm\:w-60 {
		        width: 15rem;
		    }
		    .sm\:w-64 {
		        width: 16rem;
		    }
		    .sm\:w-72 {
		        width: 18rem;
		    }
		    .sm\:w-8 {
		        width: 2rem;
		    }
		    .sm\:w-\[300px\] {
		        width: 300px;
		    }
		    .sm\:w-\[350px\] {
		        width: 350px;
		    }
		    .sm\:w-\[460px\] {
		        width: 460px;
		    }
		    .sm\:w-\[600px\] {
		        width: 600px;
		    }
		    .sm\:w-auto {
		        width: auto;
		    }
		    .sm\:w-full {
		        width: 100%;
		    }
		    .sm\:min-w-\[40px\] {
		        min-width: 40px;
		    }
		    .sm\:max-w-\[49\%\] {
		        max-width: 49%;
		    }
		    .sm\:flex-initial {
		        flex: 0 1 auto;
		    }
		    .sm\:flex-row {
		        flex-direction: row;
		    }
		    .sm\:flex-nowrap {
		        flex-wrap: nowrap;
		    }
		    .sm\:items-end {
		        align-items: flex-end;
		    }
		    .sm\:justify-start {
		        justify-content: flex-start;
		    }
		    .sm\:justify-end {
		        justify-content: flex-end;
		    }
		    .sm\:gap-10 {
		        gap: 2.5rem;
		    }
		    .sm\:gap-6 {
		        gap: 1.5rem;
		    }
		    .sm\:overflow-x-visible {
		        overflow-x: visible;
		    }
		    .sm\:whitespace-normal {
		        white-space: normal;
		    }
		    .sm\:border-0 {
		        border-width: 0px;
		    }
		    .sm\:border-b-0 {
		        border-bottom-width: 0px;
		    }
		    .sm\:border-l {
		        border-left-width: 1px;
		    }
		    .sm\:border-t-0 {
		        border-top-width: 0px;
		    }
		    .sm\:px-0 {
		        padding-left: 0px;
		        padding-right: 0px;
		    }
		    .sm\:px-10 {
		        padding-left: 2.5rem;
		        padding-right: 2.5rem;
		    }
		    .sm\:px-16 {
		        padding-left: 4rem;
		        padding-right: 4rem;
		    }
		    .sm\:px-20 {
		        padding-left: 5rem;
		        padding-right: 5rem;
		    }
		    .sm\:px-28 {
		        padding-left: 7rem;
		        padding-right: 7rem;
		    }
		    .sm\:px-3 {
		        padding-left: 0.75rem;
		        padding-right: 0.75rem;
		    }
		    .sm\:px-5 {
		        padding-left: 1.25rem;
		        padding-right: 1.25rem;
		    }
		    .sm\:px-8 {
		        padding-left: 2rem;
		        padding-right: 2rem;
		    }
		    .sm\:py-0 {
		        padding-top: 0px;
		        padding-bottom: 0px;
		    }
		    .sm\:py-20 {
		        padding-top: 5rem;
		        padding-bottom: 5rem;
		    }
		    .sm\:py-3 {
		        padding-top: 0.75rem;
		        padding-bottom: 0.75rem;
		    }
		    .sm\:py-4 {
		        padding-top: 1rem;
		        padding-bottom: 1rem;
		    }
		    .sm\:pb-0 {
		        padding-bottom: 0px;
		    }
		    .sm\:pb-20 {
		        padding-bottom: 5rem;
		    }
		    .sm\:pl-5 {
		        padding-left: 1.25rem;
		    }
		    .sm\:pt-0 {
		        padding-top: 0px;
		    }
		    .sm\:pt-20 {
		        padding-top: 5rem;
		    }
		    .sm\:pt-6 {
		        padding-top: 1.5rem;
		    }
		    .sm\:text-left {
		        text-align: left;
		    }
		    .sm\:text-right {
		        text-align: right;
		    }
		    .sm\:text-2xl {
		        font-size: 1.5rem;
		        line-height: 2rem;
		    }
		    .sm\:text-lg {
		        font-size: 1.125rem;
		        line-height: 1.75rem;
		    }
		    .sm\:text-sm {
		        font-size: 0.875rem;
		        line-height: 1.25rem;
		    }
		}
		@media (min-width: 768px) {
		    .md\:fixed {
		        position: fixed;
		    }
		    .md\:inset-x-0 {
		        left: 0px;
		        right: 0px;
		    }
		    .md\:top-0 {
		        top: 0px;
		    }
		    .md\:col-span-2 {
		        grid-column: span 2 / span 2;
		    }
		    .md\:col-span-3 {
		        grid-column: span 3 / span 3;
		    }
		    .md\:col-span-4 {
		        grid-column: span 4 / span 4;
		    }
		    .md\:col-span-6 {
		        grid-column: span 6 / span 6;
		    }
		    .md\:row-start-auto {
		        grid-row-start: auto;
		    }
		    .md\:-mx-0 {
		        margin-left: -0px;
		        margin-right: -0px;
		    }
		    .md\:-mx-\[22px\] {
		        margin-left: -22px;
		        margin-right: -22px;
		    }
		    .md\:mx-0 {
		        margin-left: 0px;
		        margin-right: 0px;
		    }
		    .md\:-mt-5 {
		        margin-top: -1.25rem;
		    }
		    .md\:-mt-\[67px\] {
		        margin-top: -67px;
		    }
		    .md\:mb-8 {
		        margin-bottom: 2rem;
		    }
		    .md\:ml-0 {
		        margin-left: 0px;
		    }
		    .md\:ml-10 {
		        margin-left: 2.5rem;
		    }
		    .md\:ml-4 {
		        margin-left: 1rem;
		    }
		    .md\:ml-auto {
		        margin-left: auto;
		    }
		    .md\:mt-0 {
		        margin-top: 0px;
		    }
		    .md\:mt-1 {
		        margin-top: 0.25rem;
		    }
		    .md\:block {
		        display: block;
		    }
		    .md\:flex {
		        display: flex;
		    }
		    .md\:hidden {
		        display: none;
		    }
		    .md\:h-\[400px\] {
		        height: 400px;
		    }
		    .md\:h-\[65px\] {
		        height: 65px;
		    }
		    .md\:w-52 {
		        width: 13rem;
		    }
		    .md\:w-\[100px\] {
		        width: 100px;
		    }
		    .md\:max-w-none {
		        max-width: none;
		    }
		    .md\:flex-row {
		        flex-direction: row;
		    }
		    .md\:items-center {
		        align-items: center;
		    }
		    .md\:rounded-\[35px\/50px_0px_0px_0px\] {
		        border-radius: 35px/50px 0px 0px 0px;
		    }
		    .md\:rounded-\[35px_35px_0_0\] {
		        border-radius: 35px 35px 0 0;
		    }
		    .md\:rounded-\[35px_35px_0px_0px\] {
		        border-radius: 35px 35px 0px 0px;
		    }
		    .md\:rounded-none {
		        border-radius: 0px;
		    }
		    .md\:border-b-0 {
		        border-bottom-width: 0px;
		    }
		    .md\:border-l {
		        border-left-width: 1px;
		    }
		    .md\:border-l-0 {
		        border-left-width: 0px;
		    }
		    .md\:border-r {
		        border-right-width: 1px;
		    }
		    .md\:border-t-0 {
		        border-top-width: 0px;
		    }
		    .md\:bg-black\/\[0\.15\] {
		        background-color: rgb(0 0 0 / 0.15);
		    }
		    .md\:bg-slate-200 {
		        --tw-bg-opacity: 1;
		        background-color: rgb(226 232 240 / var(--tw-bg-opacity));
		    }
		    .md\:bg-gradient-to-b {
		        background-image: linear-gradient(to bottom, var(--tw-gradient-stops));
		    }
		    .md\:from-slate-100 {
		        --tw-gradient-from: #f1f5f9 var(--tw-gradient-from-position);
		        --tw-gradient-to: rgb(241 245 249 / 0) var(--tw-gradient-to-position);
		        --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
		    }
		    .md\:to-transparent {
		        --tw-gradient-to: transparent var(--tw-gradient-to-position);
		    }
		    .md\:px-0 {
		        padding-left: 0px;
		        padding-right: 0px;
		    }
		    .md\:px-10 {
		        padding-left: 2.5rem;
		        padding-right: 2.5rem;
		    }
		    .md\:px-5 {
		        padding-left: 1.25rem;
		        padding-right: 1.25rem;
		    }
		    .md\:px-6 {
		        padding-left: 1.5rem;
		        padding-right: 1.5rem;
		    }
		    .md\:px-\[22px\] {
		        padding-left: 22px;
		        padding-right: 22px;
		    }
		    .md\:py-0 {
		        padding-top: 0px;
		        padding-bottom: 0px;
		    }
		    .md\:pl-0 {
		        padding-left: 0px;
		    }
		    .md\:pl-10 {
		        padding-left: 2.5rem;
		    }
		    .md\:pl-6 {
		        padding-left: 1.5rem;
		    }
		    .md\:pt-0 {
		        padding-top: 0px;
		    }
		    .md\:pt-10 {
		        padding-top: 2.5rem;
		    }
		    .md\:pt-20 {
		        padding-top: 5rem;
		    }
		    .md\:pt-\[80px\] {
		        padding-top: 80px;
		    }
		    .before\:md\:block::before {
		        content: var(--tw-content);
		        display: block;
		    }
		    .md\:before\:bg-none::before {
		        content: var(--tw-content);
		        background-image: none;
		    }
		    .after\:md\:block::after {
		        content: var(--tw-content);
		        display: block;
		    }
		    .md\:after\:block::after {
		        content: var(--tw-content);
		        display: block;
		    }
		    :is(.dark .md\:dark\:bg-darkmode-800) {
		        --tw-bg-opacity: 1;
		        background-color: rgb(var(--color-darkmode-800) / var(--tw-bg-opacity));
		    }
		    :is(.dark .dark\:md\:from-darkmode-700) {
		        --tw-gradient-from: rgb(var(--color-darkmode-700) / 1) var(--tw-gradient-from-position);
		        --tw-gradient-to: rgb(var(--color-darkmode-700) / 0) var(--tw-gradient-to-position);
		        --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
		    }
		    :is(.dark .dark\:md\:from-darkmode-800) {
		        --tw-gradient-from: rgb(var(--color-darkmode-800) / 1) var(--tw-gradient-from-position);
		        --tw-gradient-to: rgb(var(--color-darkmode-800) / 0) var(--tw-gradient-to-position);
		        --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
		    }
		}
		@media (min-width: 1024px) {
		    .lg\:col-span-2 {
		        grid-column: span 2 / span 2;
		    }
		    .lg\:col-span-3 {
		        grid-column: span 3 / span 3;
		    }
		    .lg\:col-span-4 {
		        grid-column: span 4 / span 4;
		    }
		    .lg\:col-span-6 {
		        grid-column: span 6 / span 6;
		    }
		    .lg\:col-span-7 {
		        grid-column: span 7 / span 7;
		    }
		    .lg\:col-span-8 {
		        grid-column: span 8 / span 8;
		    }
		    .lg\:col-span-9 {
		        grid-column: span 9 / span 9;
		    }
		    .lg\:row-start-3 {
		        grid-row-start: 3;
		    }
		    .lg\:mx-auto {
		        margin-left: auto;
		        margin-right: auto;
		    }
		    .lg\:mb-0 {
		        margin-bottom: 0px;
		    }
		    .lg\:ml-0 {
		        margin-left: 0px;
		    }
		    .lg\:ml-2 {
		        margin-left: 0.5rem;
		    }
		    .lg\:ml-4 {
		        margin-left: 1rem;
		    }
		    .lg\:ml-5 {
		        margin-left: 1.25rem;
		    }
		    .lg\:ml-8 {
		        margin-left: 2rem;
		    }
		    .lg\:ml-auto {
		        margin-left: auto;
		    }
		    .lg\:mr-1 {
		        margin-right: 0.25rem;
		    }
		    .lg\:mr-20 {
		        margin-right: 5rem;
		    }
		    .lg\:mr-auto {
		        margin-right: auto;
		    }
		    .lg\:mt-0 {
		        margin-top: 0px;
		    }
		    .lg\:mt-3 {
		        margin-top: 0.75rem;
		    }
		    .lg\:mt-5 {
		        margin-top: 1.25rem;
		    }
		    .lg\:mt-6 {
		        margin-top: 1.5rem;
		    }
		    .lg\:block {
		        display: block;
		    }
		    .lg\:flex {
		        display: flex;
		    }
		    .lg\:h-12 {
		        height: 3rem;
		    }
		    .lg\:h-32 {
		        height: 8rem;
		    }
		    .lg\:h-auto {
		        height: auto;
		    }
		    .lg\:w-1\/2 {
		        width: 50%;
		    }
		    .lg\:w-12 {
		        width: 3rem;
		    }
		    .lg\:w-2\/4 {
		        width: 50%;
		    }
		    .lg\:w-32 {
		        width: 8rem;
		    }
		    .lg\:w-40 {
		        width: 10rem;
		    }
		    .lg\:w-56 {
		        width: 14rem;
		    }
		    .lg\:w-64 {
		        width: 16rem;
		    }
		    .lg\:w-\[900px\] {
		        width: 900px;
		    }
		    .lg\:w-auto {
		        width: auto;
		    }
		    .lg\:flex-row {
		        flex-direction: row;
		    }
		    .lg\:flex-nowrap {
		        flex-wrap: nowrap;
		    }
		    .lg\:items-start {
		        align-items: flex-start;
		    }
		    .lg\:justify-start {
		        justify-content: flex-start;
		    }
		    .lg\:justify-end {
		        justify-content: flex-end;
		    }
		    .lg\:justify-center {
		        justify-content: center;
		    }
		    .lg\:overflow-hidden {
		        overflow: hidden;
		    }
		    .lg\:overflow-visible {
		        overflow: visible;
		    }
		    .lg\:border-0 {
		        border-width: 0px;
		    }
		    .lg\:border-b-0 {
		        border-bottom-width: 0px;
		    }
		    .lg\:border-l {
		        border-left-width: 1px;
		    }
		    .lg\:border-r {
		        border-right-width: 1px;
		    }
		    .lg\:border-t-0 {
		        border-top-width: 0px;
		    }
		    .lg\:px-5 {
		        padding-left: 1.25rem;
		        padding-right: 1.25rem;
		    }
		    .lg\:px-6 {
		        padding-left: 1.5rem;
		        padding-right: 1.5rem;
		    }
		    .lg\:py-3 {
		        padding-top: 0.75rem;
		        padding-bottom: 0.75rem;
		    }
		    .lg\:pb-0 {
		        padding-bottom: 0px;
		    }
		    .lg\:pb-20 {
		        padding-bottom: 5rem;
		    }
		    .lg\:pl-5 {
		        padding-left: 1.25rem;
		    }
		    .lg\:pt-0 {
		        padding-top: 0px;
		    }
		    .lg\:text-left {
		        text-align: left;
		    }
		    .lg\:text-center {
		        text-align: center;
		    }
		    .lg\:text-right {
		        text-align: right;
		    }
		    .lg\:text-justify {
		        text-align: justify;
		    }
		    .lg\:text-3xl {
		        font-size: 1.875rem;
		        line-height: 2.25rem;
		    }
		    .before\:lg\:block::before {
		        content: var(--tw-content);
		        display: block;
		    }
		    @keyframes ping {
		        75%, 100% {
		            content: var(--tw-content);
		            transform: scale(2);
		            opacity: 0;
		        }
		    }
		    .lg\:before\:animate-ping::before {
		        content: var(--tw-content);
		        animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
		    }
		}
		@media (min-width: 1280px) {
		    .xl\:absolute {
		        position: absolute;
		    }
		    .xl\:sticky {
		        position: sticky;
		    }
		    .xl\:z-auto {
		        z-index: auto;
		    }
		    .xl\:col-span-1 {
		        grid-column: span 1 / span 1;
		    }
		    .xl\:col-span-12 {
		        grid-column: span 12 / span 12;
		    }
		    .xl\:col-span-2 {
		        grid-column: span 2 / span 2;
		    }
		    .xl\:col-span-3 {
		        grid-column: span 3 / span 3;
		    }
		    .xl\:col-span-4 {
		        grid-column: span 4 / span 4;
		    }
		    .xl\:col-span-6 {
		        grid-column: span 6 / span 6;
		    }
		    .xl\:col-span-8 {
		        grid-column: span 8 / span 8;
		    }
		    .xl\:col-span-9 {
		        grid-column: span 9 / span 9;
		    }
		    .xl\:col-start-1 {
		        grid-column-start: 1;
		    }
		    .xl\:col-start-10 {
		        grid-column-start: 10;
		    }
		    .xl\:row-start-1 {
		        grid-row-start: 1;
		    }
		    .xl\:row-start-2 {
		        grid-row-start: 2;
		    }
		    .xl\:row-start-auto {
		        grid-row-start: auto;
		    }
		    .xl\:mx-5 {
		        margin-left: 1.25rem;
		        margin-right: 1.25rem;
		    }
		    .xl\:mx-6 {
		        margin-left: 1.5rem;
		        margin-right: 1.5rem;
		    }
		    .xl\:my-0 {
		        margin-top: 0px;
		        margin-bottom: 0px;
		    }
		    .xl\:\!mr-10 {
		        margin-right: 2.5rem !important;
		    }
		    .xl\:-mt-5 {
		        margin-top: -1.25rem;
		    }
		    .xl\:-mt-\[3px\] {
		        margin-top: -3px;
		    }
		    .xl\:-mt-\[62px\] {
		        margin-top: -62px;
		    }
		    .xl\:ml-20 {
		        margin-left: 5rem;
		    }
		    .xl\:ml-5 {
		        margin-left: 1.25rem;
		    }
		    .xl\:ml-6 {
		        margin-left: 1.5rem;
		    }
		    .xl\:ml-64 {
		        margin-left: 16rem;
		    }
		    .xl\:ml-auto {
		        margin-left: auto;
		    }
		    .xl\:mr-0 {
		        margin-right: 0px;
		    }
		    .xl\:mr-3 {
		        margin-right: 0.75rem;
		    }
		    .xl\:mt-0 {
		        margin-top: 0px;
		    }
		    .xl\:mt-2 {
		        margin-top: 0.5rem;
		    }
		    .xl\:mt-24 {
		        margin-top: 6rem;
		    }
		    .xl\:mt-8 {
		        margin-top: 2rem;
		    }
		    .xl\:block {
		        display: block;
		    }
		    .xl\:flex {
		        display: flex;
		    }
		    .xl\:grid {
		        display: grid;
		    }
		    .xl\:hidden {
		        display: none;
		    }
		    .xl\:h-auto {
		        height: auto;
		    }
		    .xl\:min-h-0 {
		        min-height: 0px;
		    }
		    .xl\:w-3\/5 {
		        width: 60%;
		    }
		    .xl\:w-32 {
		        width: 8rem;
		    }
		    .xl\:w-64 {
		        width: 16rem;
		    }
		    .xl\:w-\[100px\] {
		        width: 100px;
		    }
		    .xl\:w-\[180px\] {
		        width: 180px;
		    }
		    .xl\:w-\[230px\] {
		        width: 230px;
		    }
		    .xl\:w-\[250px\] {
		        width: 250px;
		    }
		    .xl\:w-\[260px\] {
		        width: 260px;
		    }
		    .xl\:w-auto {
		        width: auto;
		    }
		    .xl\:min-w-\[350px\] {
		        min-width: 350px;
		    }
		    .xl\:flex-initial {
		        flex: 0 1 auto;
		    }
		    .xl\:flex-row {
		        flex-direction: row;
		    }
		    .xl\:flex-nowrap {
		        flex-wrap: nowrap;
		    }
		    .xl\:items-start {
		        align-items: flex-start;
		    }
		    .xl\:overflow-y-auto {
		        overflow-y: auto;
		    }
		    .xl\:bg-theme-1 {
		        --tw-bg-opacity: 1;
		        background-color: rgb(var(--color-theme-1) / var(--tw-bg-opacity));
		    }
		    .xl\:bg-transparent {
		        background-color: transparent;
		    }
		    .xl\:bg-white {
		        --tw-bg-opacity: 1;
		        background-color: rgb(255 255 255 / var(--tw-bg-opacity));
		    }
		    .xl\:p-0 {
		        padding: 0px;
		    }
		    .xl\:px-0 {
		        padding-left: 0px;
		        padding-right: 0px;
		    }
		    .xl\:px-6 {
		        padding-left: 1.5rem;
		        padding-right: 1.5rem;
		    }
		    .xl\:px-\[50px\] {
		        padding-left: 50px;
		        padding-right: 50px;
		    }
		    .xl\:py-0 {
		        padding-top: 0px;
		        padding-bottom: 0px;
		    }
		    .xl\:pb-0 {
		        padding-bottom: 0px;
		    }
		    .xl\:pb-16 {
		        padding-bottom: 4rem;
		    }
		    .xl\:pl-10 {
		        padding-left: 2.5rem;
		    }
		    .xl\:pl-5 {
		        padding-left: 1.25rem;
		    }
		    .xl\:pr-10 {
		        padding-right: 2.5rem;
		    }
		    .xl\:pr-20 {
		        padding-right: 5rem;
		    }
		    .xl\:pt-\[12px\] {
		        padding-top: 12px;
		    }
		    .xl\:text-left {
		        text-align: left;
		    }
		    .xl\:text-right {
		        text-align: right;
		    }
		    .xl\:text-3xl {
		        font-size: 1.875rem;
		        line-height: 2.25rem;
		    }
		    .xl\:text-xl {
		        font-size: 1.25rem;
		        line-height: 1.75rem;
		    }
		    .xl\:shadow-none {
		        --tw-shadow: 0 0 #0000;
		        --tw-shadow-colored: 0 0 #0000;
		        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
		    }
		    .before\:xl\:block::before {
		        content: var(--tw-content);
		        display: block;
		    }
		    .xl\:before\:block::before {
		        content: var(--tw-content);
		        display: block;
		    }
		    .xl\:before\:rounded-t-\[30px\]::before {
		        content: var(--tw-content);
		        border-top-left-radius: 30px;
		        border-top-right-radius: 30px;
		    }
		    .xl\:before\:bg-white\/10::before {
		        content: var(--tw-content);
		        background-color: rgb(255 255 255 / 0.1);
		    }
		    .xl\:before\:shadow-\[0px_3px_20px_\#0000000b\]::before {
		        content: var(--tw-content);
		        --tw-shadow: 0px 3px 20px #0000000b;
		        --tw-shadow-colored: 0px 3px 20px var(--tw-shadow-color);
		        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
		    }
		    .after\:xl\:block::after {
		        content: var(--tw-content);
		        display: block;
		    }
		    :is(.dark .xl\:dark\:bg-darkmode-400) {
		        --tw-bg-opacity: 1;
		        background-color: rgb(var(--color-darkmode-400) / var(--tw-bg-opacity));
		    }
		    :is(.dark .xl\:dark\:bg-darkmode-600) {
		        --tw-bg-opacity: 1;
		        background-color: rgb(var(--color-darkmode-600) / var(--tw-bg-opacity));
		    }
		}
		@media (min-width: 1536px) {
		    .\32xl\:z-10 {
		        z-index: 10;
		    }
		    .\32xl\:col-span-10 {
		        grid-column: span 10 / span 10;
		    }
		    .\32xl\:col-span-12 {
		        grid-column: span 12 / span 12;
		    }
		    .\32xl\:col-span-2 {
		        grid-column: span 2 / span 2;
		    }
		    .\32xl\:col-span-3 {
		        grid-column: span 3 / span 3;
		    }
		    .\32xl\:col-span-4 {
		        grid-column: span 4 / span 4;
		    }
		    .\32xl\:col-span-5 {
		        grid-column: span 5 / span 5;
		    }
		    .\32xl\:col-span-6 {
		        grid-column: span 6 / span 6;
		    }
		    .\32xl\:col-span-8 {
		        grid-column: span 8 / span 8;
		    }
		    .\32xl\:col-span-9 {
		        grid-column: span 9 / span 9;
		    }
		    .\32xl\:col-start-auto {
		        grid-column-start: auto;
		    }
		    .\32xl\:row-start-auto {
		        grid-row-start: auto;
		    }
		    .\32xl\:-ml-20 {
		        margin-left: -5rem;
		    }
		    .\32xl\:-mt-1 {
		        margin-top: -0.25rem;
		    }
		    .\32xl\:-mt-1\.5 {
		        margin-top: -0.375rem;
		    }
		    .\32xl\:-mt-8 {
		        margin-top: -2rem;
		    }
		    .\32xl\:mb-0 {
		        margin-bottom: 0px;
		    }
		    .\32xl\:ml-16 {
		        margin-left: 4rem;
		    }
		    .\32xl\:mr-auto {
		        margin-right: auto;
		    }
		    .\32xl\:mt-0 {
		        margin-top: 0px;
		    }
		    .\32xl\:mt-24 {
		        margin-top: 6rem;
		    }
		    .\32xl\:mt-6 {
		        margin-top: 1.5rem;
		    }
		    .\32xl\:mt-8 {
		        margin-top: 2rem;
		    }
		    .\32xl\:block {
		        display: block;
		    }
		    .\32xl\:flex {
		        display: flex;
		    }
		    .\32xl\:h-56 {
		        height: 14rem;
		    }
		    .\32xl\:w-14 {
		        width: 3.5rem;
		    }
		    .\32xl\:w-2\/3 {
		        width: 66.666667%;
		    }
		    .\32xl\:w-4\/6 {
		        width: 66.666667%;
		    }
		    .\32xl\:w-52 {
		        width: 13rem;
		    }
		    .\32xl\:w-full {
		        width: 100%;
		    }
		    .\32xl\:flex-none {
		        flex: none;
		    }
		    .\32xl\:grid-cols-7 {
		        grid-template-columns: repeat(7, minmax(0, 1fr));
		    }
		    .\32xl\:justify-center {
		        justify-content: center;
		    }
		    .\32xl\:gap-x-0 {
		        -moz-column-gap: 0px;
		             column-gap: 0px;
		    }
		    .\32xl\:overflow-visible {
		        overflow: visible;
		    }
		    .\32xl\:border-l {
		        border-left-width: 1px;
		    }
		    .\32xl\:bg-transparent {
		        background-color: transparent;
		    }
		    .\32xl\:p-0 {
		        padding: 0px;
		    }
		    .\32xl\:px-6 {
		        padding-left: 1.5rem;
		        padding-right: 1.5rem;
		    }
		    .\32xl\:pl-2 {
		        padding-left: 0.5rem;
		    }
		    .\32xl\:pl-2\.5 {
		        padding-left: 0.625rem;
		    }
		    .\32xl\:pl-4 {
		        padding-left: 1rem;
		    }
		    .\32xl\:pl-6 {
		        padding-left: 1.5rem;
		    }
		    .\32xl\:pt-0 {
		        padding-top: 0px;
		    }
		    .\32xl\:text-2xl {
		        font-size: 1.5rem;
		        line-height: 2rem;
		    }
		    .\32xl\:text-3xl {
		        font-size: 1.875rem;
		        line-height: 2.25rem;
		    }
		    .\32xl\:text-base {
		        font-size: 1rem;
		        line-height: 1.5rem;
		    }
		    .\32xl\:text-lg {
		        font-size: 1.125rem;
		        line-height: 1.75rem;
		    }
		    .\32xl\:text-sm {
		        font-size: 0.875rem;
		        line-height: 1.25rem;
		    }
		    .\32xl\:text-xl {
		        font-size: 1.25rem;
		        line-height: 1.75rem;
		    }
		    .\32xl\:leading-5 {
		        line-height: 1.25rem;
		    }
		    .\32xl\:text-success {
		        --tw-text-opacity: 1;
		        color: rgb(var(--color-success) / var(--tw-text-opacity));
		    }
		}
		.\[\&\.active\]\:border-2.active {
		    border-width: 2px;
		}
		.\[\&\.active\]\:border-theme-1\/60.active {
		    border-color: rgb(var(--color-theme-1) / 0.6);
		}
		.\[\&\.dropzone\]\:border-2.dropzone {
		    border-width: 2px;
		}
		.\[\&\.dropzone\]\:border-dashed.dropzone {
		    border-style: dashed;
		}
		.\[\&\.dropzone\]\:border-darkmode-200\/60.dropzone {
		    border-color: rgb(var(--color-darkmode-200) / 0.6);
		}
		:is(.dark .\[\&\.dropzone\]\:dark\:border-white\/5).dropzone {
		    border-color: rgb(255 255 255 / 0.05);
		}
		:is(.dark .\[\&\.dropzone\]\:dark\:bg-darkmode-600).dropzone {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-600) / var(--tw-bg-opacity));
		}
		.\[\&\.hljs\]\:bg-slate-50.hljs {
		    --tw-bg-opacity: 1;
		    background-color: rgb(248 250 252 / var(--tw-bg-opacity));
		}
		.\[\&\.hljs\]\:px-5.hljs {
		    padding-left: 1.25rem;
		    padding-right: 1.25rem;
		}
		.\[\&\.hljs\]\:py-4.hljs {
		    padding-top: 1rem;
		    padding-bottom: 1rem;
		}
		:is(.dark .\[\&\.hljs\]\:dark\:bg-darkmode-700).hljs {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-700) / var(--tw-bg-opacity));
		}
		:is(.dark .\[\&\.hljs\]\:dark\:text-slate-200).hljs {
		    --tw-text-opacity: 1;
		    color: rgb(226 232 240 / var(--tw-text-opacity));
		}
		:is(.dark .\[\&\.hljs_\.hljs-attr\]\:dark\:text-sky-500).hljs .hljs-attr {
		    --tw-text-opacity: 1;
		    color: rgb(14 165 233 / var(--tw-text-opacity));
		}
		:is(.dark .\[\&\.hljs_\.hljs-name\]\:dark\:text-emerald-500).hljs .hljs-name {
		    --tw-text-opacity: 1;
		    color: rgb(16 185 129 / var(--tw-text-opacity));
		}
		:is(.dark .\[\&\.hljs_\.hljs-string\]\:dark\:text-slate-200).hljs .hljs-string {
		    --tw-text-opacity: 1;
		    color: rgb(226 232 240 / var(--tw-text-opacity));
		}
		:is(.dark .\[\&\.hljs_\.hljs-tag\]\:dark\:text-slate-200).hljs .hljs-tag {
		    --tw-text-opacity: 1;
		    color: rgb(226 232 240 / var(--tw-text-opacity));
		}
		.\[\&\.javascript\]\:before\:content-\[\'JS\'\].javascript::before {
		    --tw-content: 'JS';
		    content: var(--tw-content);
		}
		.\[\&\.mobile-menu--active\]\:before\:visible.mobile-menu--active::before {
		    content: var(--tw-content);
		    visibility: visible;
		}
		.\[\&\.mobile-menu--active\]\:before\:opacity-100.mobile-menu--active::before {
		    content: var(--tw-content);
		    opacity: 1;
		}
		.\[\&\:disabled\:checked\]\:cursor-not-allowed:disabled:checked {
		    cursor: not-allowed;
		}
		.\[\&\:disabled\:checked\]\:opacity-70:disabled:checked {
		    opacity: 0.7;
		}
		:is(.dark .\[\&\:disabled\:checked\]\:dark\:bg-darkmode-800\/50):disabled:checked {
		    background-color: rgb(var(--color-darkmode-800) / 0.5);
		}
		.\[\&\:disabled\:not\(\:checked\)\]\:cursor-not-allowed:disabled:not(:checked) {
		    cursor: not-allowed;
		}
		.\[\&\:disabled\:not\(\:checked\)\]\:bg-slate-100:disabled:not(:checked) {
		    --tw-bg-opacity: 1;
		    background-color: rgb(241 245 249 / var(--tw-bg-opacity));
		}
		:is(.dark .\[\&\:disabled\:not\(\:checked\)\]\:dark\:bg-darkmode-800\/50):disabled:not(:checked) {
		    background-color: rgb(var(--color-darkmode-800) / 0.5);
		}
		.\[\&\:hover\:not\(\:disabled\)\]\:border-slate-100:hover:not(:disabled) {
		    --tw-border-opacity: 1;
		    border-color: rgb(241 245 249 / var(--tw-border-opacity));
		}
		.\[\&\:hover\:not\(\:disabled\)\]\:border-opacity-10:hover:not(:disabled) {
		    --tw-border-opacity: 0.1;
		}
		.\[\&\:hover\:not\(\:disabled\)\]\:border-opacity-90:hover:not(:disabled) {
		    --tw-border-opacity: 0.9;
		}
		.\[\&\:hover\:not\(\:disabled\)\]\:bg-danger\/10:hover:not(:disabled) {
		    background-color: rgb(var(--color-danger) / 0.1);
		}
		.\[\&\:hover\:not\(\:disabled\)\]\:bg-darkmode-800\/30:hover:not(:disabled) {
		    background-color: rgb(var(--color-darkmode-800) / 0.3);
		}
		.\[\&\:hover\:not\(\:disabled\)\]\:bg-pending\/10:hover:not(:disabled) {
		    background-color: rgb(var(--color-pending) / 0.1);
		}
		.\[\&\:hover\:not\(\:disabled\)\]\:bg-primary\/10:hover:not(:disabled) {
		    background-color: rgb(var(--color-primary) / 0.1);
		}
		.\[\&\:hover\:not\(\:disabled\)\]\:bg-secondary\/20:hover:not(:disabled) {
		    background-color: rgb(var(--color-secondary) / 0.2);
		}
		.\[\&\:hover\:not\(\:disabled\)\]\:bg-slate-100:hover:not(:disabled) {
		    --tw-bg-opacity: 1;
		    background-color: rgb(241 245 249 / var(--tw-bg-opacity));
		}
		.\[\&\:hover\:not\(\:disabled\)\]\:bg-success\/10:hover:not(:disabled) {
		    background-color: rgb(var(--color-success) / 0.1);
		}
		.\[\&\:hover\:not\(\:disabled\)\]\:bg-warning\/10:hover:not(:disabled) {
		    background-color: rgb(var(--color-warning) / 0.1);
		}
		.\[\&\:hover\:not\(\:disabled\)\]\:bg-opacity-10:hover:not(:disabled) {
		    --tw-bg-opacity: 0.1;
		}
		.\[\&\:hover\:not\(\:disabled\)\]\:bg-opacity-90:hover:not(:disabled) {
		    --tw-bg-opacity: 0.9;
		}
		:is(.dark .\[\&\:hover\:not\(\:disabled\)\]\:dark\:border-darkmode-100\/20):hover:not(:disabled) {
		    border-color: rgb(var(--color-darkmode-100) / 0.2);
		}
		:is(.dark .\[\&\:hover\:not\(\:disabled\)\]\:dark\:border-darkmode-300\/80):hover:not(:disabled) {
		    border-color: rgb(var(--color-darkmode-300) / 0.8);
		}
		:is(.dark .\[\&\:hover\:not\(\:disabled\)\]\:dark\:border-darkmode-800):hover:not(:disabled) {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-darkmode-800) / var(--tw-border-opacity));
		}
		:is(.dark .\[\&\:hover\:not\(\:disabled\)\]\:dark\:border-opacity-60):hover:not(:disabled) {
		    --tw-border-opacity: 0.6;
		}
		:is(.dark .\[\&\:hover\:not\(\:disabled\)\]\:dark\:bg-darkmode-100\/10):hover:not(:disabled) {
		    background-color: rgb(var(--color-darkmode-100) / 0.1);
		}
		:is(.dark .\[\&\:hover\:not\(\:disabled\)\]\:dark\:bg-darkmode-300\/80):hover:not(:disabled) {
		    background-color: rgb(var(--color-darkmode-300) / 0.8);
		}
		:is(.dark .\[\&\:hover\:not\(\:disabled\)\]\:dark\:bg-darkmode-800\/50):hover:not(:disabled) {
		    background-color: rgb(var(--color-darkmode-800) / 0.5);
		}
		:is(.dark :is(.dark .\[\&\:hover\:not\(\:disabled\)\]\:dark\:dark\:bg-darkmode-800\/70)):hover:not(:disabled) {
		    background-color: rgb(var(--color-darkmode-800) / 0.7);
		}
		:is(.dark .\[\&\:hover\:not\(\:disabled\)\]\:dark\:bg-opacity-30):hover:not(:disabled) {
		    --tw-bg-opacity: 0.3;
		}
		.\[\&\:hover_td\]\:bg-slate-100:hover td {
		    --tw-bg-opacity: 1;
		    background-color: rgb(241 245 249 / var(--tw-bg-opacity));
		}
		:is(.dark .\[\&\:hover_td\]\:dark\:bg-darkmode-300):hover td {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-300) / var(--tw-bg-opacity));
		}
		:is(.dark .\[\&\:hover_td\]\:dark\:bg-opacity-50):hover td {
		    --tw-bg-opacity: 0.5;
		}
		.\[\&\:not\(\:first-child\)\]\:border-l-transparent:not(:first-child) {
		    border-left-color: transparent;
		}
		.\[\&\:not\(\:last-child\)\]\:border-b:not(:last-child) {
		    border-bottom-width: 1px;
		}
		.\[\&\:not\(\:last-child\)\]\:border-slate-200\/60:not(:last-child) {
		    border-color: rgb(226 232 240 / 0.6);
		}
		:is(.dark .\[\&\:not\(\:last-child\)\]\:dark\:border-darkmode-400):not(:last-child) {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-darkmode-400) / var(--tw-border-opacity));
		}
		.\[\&\:not\(button\)\]\:text-center:not(button) {
		    text-align: center;
		}
		.\[\&\:nth-of-type\(odd\)_td\]\:bg-slate-100:nth-of-type(odd) td {
		    --tw-bg-opacity: 1;
		    background-color: rgb(241 245 249 / var(--tw-bg-opacity));
		}
		:is(.dark .\[\&\:nth-of-type\(odd\)_td\]\:dark\:bg-darkmode-300):nth-of-type(odd) td {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-darkmode-300) / var(--tw-bg-opacity));
		}
		:is(.dark .\[\&\:nth-of-type\(odd\)_td\]\:dark\:bg-opacity-50):nth-of-type(odd) td {
		    --tw-bg-opacity: 0.5;
		}
		.\[\&\>div\:nth-child\(2\)\]\:w-full>div:nth-child(2) {
		    width: 100%;
		}
		.\[\&\[data-simplebar\]\]\:fixed[data-simplebar] {
		    position: fixed;
		}
		.\[\&\[readonly\]\]\:cursor-not-allowed[readonly] {
		    cursor: not-allowed;
		}
		.\[\&\[readonly\]\]\:bg-slate-100[readonly] {
		    --tw-bg-opacity: 1;
		    background-color: rgb(241 245 249 / var(--tw-bg-opacity));
		}
		:is(.dark .\[\&\[readonly\]\]\:dark\:border-transparent)[readonly] {
		    border-color: transparent;
		}
		:is(.dark .\[\&\[readonly\]\]\:dark\:bg-darkmode-800\/50)[readonly] {
		    background-color: rgb(var(--color-darkmode-800) / 0.5);
		}
		.\[\&\[type\=\'checkbox\'\]\]\:checked\:border-primary:checked[type='checkbox'] {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-primary) / var(--tw-border-opacity));
		}
		.\[\&\[type\=\'checkbox\'\]\]\:checked\:border-opacity-10:checked[type='checkbox'] {
		    --tw-border-opacity: 0.1;
		}
		.\[\&\[type\=\'checkbox\'\]\]\:checked\:bg-primary:checked[type='checkbox'] {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-primary) / var(--tw-bg-opacity));
		}
		.\[\&\[type\=\'radio\'\]\]\:checked\:border-primary:checked[type='radio'] {
		    --tw-border-opacity: 1;
		    border-color: rgb(var(--color-primary) / var(--tw-border-opacity));
		}
		.\[\&\[type\=\'radio\'\]\]\:checked\:border-opacity-10:checked[type='radio'] {
		    --tw-border-opacity: 0.1;
		}
		.\[\&\[type\=\'radio\'\]\]\:checked\:bg-primary:checked[type='radio'] {
		    --tw-bg-opacity: 1;
		    background-color: rgb(var(--color-primary) / var(--tw-bg-opacity));
		}
		.\[\&_\.leaflet-tile-pane\]\:brightness-90 .leaflet-tile-pane {
		    --tw-brightness: brightness(.9);
		    filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);
		}
		.\[\&_\.leaflet-tile-pane\]\:grayscale .leaflet-tile-pane {
		    --tw-grayscale: grayscale(100%);
		    filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);
		}
		.\[\&_\.leaflet-tile-pane\]\:hue-rotate-15 .leaflet-tile-pane {
		    --tw-hue-rotate: hue-rotate(15deg);
		    filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);
		}
		.\[\&_\.leaflet-tile-pane\]\:invert .leaflet-tile-pane {
		    --tw-invert: invert(100%);
		    filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);
		}
		.\[\&_\.leaflet-tile-pane\]\:saturate-\[\.3\] .leaflet-tile-pane {
		    --tw-saturate: saturate(.3);
		    filter: var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow);
		}
		.\[\&_\.simplebar-scrollbar\]\:before\:bg-black\/50 .simplebar-scrollbar::before {
		    content: var(--tw-content);
		    background-color: rgb(0 0 0 / 0.5);
		}
	</style>
</head>
	<body>
		<div id="app" data-v-app="">
			<div class="py-2 bg-gradient-to-b from-theme-1 to-theme-2 dark:from-darkmode-800 dark:to-darkmode-800">
				<div><!---->
					<div class="fixed bottom-0 right-0 z-50 flex items-center justify-center mb-5 mr-5 text-white rounded-full shadow-lg cursor-pointer h-14 w-14 bg-theme-1" style="margin-bottom: 95px; margin-right: 10px;">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings-icon stroke-1.5 w-5 h-5 animate-spin w-5 h-5 animate-spin">
							<path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
							<circle cx="12" cy="12" r="3"></circle>
						</svg>
					</div>
				</div>
				<div class="container"><!-- BEGIN: Error Page -->
					<div class="flex flex-col items-center justify-center h-screen text-center error-page lg:flex-row lg:text-left">
						<div class="-intro-x lg:mr-20">
							<img alt="Midone Tailwind HTML Admin Template" class="w-[450px] h-48 lg:h-auto" src="http://localhost:5174/resources/@client/assets/images/error-illustration.svg">
						</div>
						<div class="mt-10 text-white lg:mt-0">
							<div class="font-medium intro-x text-8xl">503</div>
							<div class="mt-5 text-xl font-medium intro-x lg:text-3xl"> Oops. We're working on something right now... </div>
							<div class="mt-3 text-lg intro-x"> The site is in maintenance mode. Usually this will only last seconds, but sometimes longer. Much longer. </div>
						</div>
					</div><!-- END: Error Page -->
				</div>
			</div>
			<div tabindex="0" class="vl-overlay vl-active vl-full-page" aria-busy="false" aria-label="Loading" style="display: none;">
				<div class="vl-background"></div>
				<div class="vl-icon">
					<svg width="20%" viewBox="0 0 57 57" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
						<g fill="none" fill-rule="evenodd">
							<g transform="translate(1 1)">
								<circle cx="5" cy="50" r="5" fill="rgb(30 58 138 / 1)">
									<animate attributeName="cy" begin="0s" dur="2.2s" values="50;5;50;50" calcMode="linear" repeatCount="indefinite"></animate>
									<animate attributeName="cx" begin="0s" dur="2.2s" values="5;27;49;5" calcMode="linear" repeatCount="indefinite"></animate>
								</circle>
								<circle cx="27" cy="5" r="5" fill="rgb(30 58 138 / 1)">
									<animate attributeName="cy" begin="0s" dur="2.2s" from="5" to="5" values="5;50;50;5" calcMode="linear" repeatCount="indefinite"></animate>
									<animate attributeName="cx" begin="0s" dur="2.2s" from="27" to="27" values="27;49;5;27" calcMode="linear" repeatCount="indefinite"></animate>
								</circle>
								<circle cx="49" cy="50" r="5" fill="rgb(30 58 138 / 1)">
									<animate attributeName="cy" begin="0s" dur="2.2s" values="50;50;5;50" calcMode="linear" repeatCount="indefinite"></animate>
									<animate attributeName="cx" from="49" to="49" begin="0s" dur="2.2s" values="49;5;27;49" calcMode="linear" repeatCount="indefinite"></animate>
								</circle>
							</g>
						</g>
					</svg>
					<h2 class="mr-5 text-lg font-medium truncate" style="text-align: center; margin-top: 25px;"></h2>
				</div>
			</div>
		</div>
	</body>
</html>