(function () {
  "use strict";

  // Toggle accordion content
  $("body").on("click", "[data-tw-toggle='collapse']", function () {
    toggle(this);
  });

  function toggle(el, event = "toggle") {
    $(el)
      .closest(".accordion")
      .find("[data-tw-toggle='collapse']")
      .each(function () {
        // Trigger "hide.tw.accordion" callback function
        if (
          !$(this).hasClass("collapsed") &&
          this !== el &&
          (event == "toggle" || event == "hide")
        ) {
          const event = new Event("hide.tw.accordion");
          $(this).closest(".accordion-header")[0].dispatchEvent(event);
        }

        // Trigger "show.tw.accordion" callback function
        if (
          $(this).hasClass("collapsed") &&
          this === el &&
          (event == "toggle" || event == "show")
        ) {
          const event = new Event("show.tw.accordion");
          $(this).closest(".accordion-header")[0].dispatchEvent(event);
        }
      });

    const collapsed = $(el).hasClass("collapsed");

    // Close active accordion
    $(el)
      .closest(".accordion")
      .find(".accordion-collapse")
      .slideUp(300, (el) => {
        $(el).removeClass("show");
        $(el)
          .closest(".accordion-item")
          .find("[data-tw-toggle='collapse']")
          .addClass("collapsed")
          .attr("aria-expanded", false);
      });

    // Set active accordion
    setTimeout(() => {
      const accordionCollapse = $(el)
        .closest(".accordion-item")
        .find(".accordion-collapse");

      const hide = () => {
        $(accordionCollapse).removeClass("show");
        $(el).addClass("collapsed").attr("aria-expanded", false);
        $(el).closest(".accordion-item").find(".accordion-collapse").slideUp();
      };

      const show = () => {
        $(accordionCollapse).addClass("show");
        $(el).removeClass("collapsed").attr("aria-expanded", true);
        $(el)
          .closest(".accordion-item")
          .find(".accordion-collapse")
          .slideDown();
      };

      if (event === "toggle") {
        !collapsed ? hide() : show();
      } else if (event === "show") {
        show();
      } else {
        hide();
      }
    }, 300);
  }

  // Create instance
  function createInstance(el) {
    return {
      show() {
        toggle(el, "show");
      },
      hide() {
        toggle(el, "hide");
      },
      toggle() {
        toggle(el);
      },
    };
  }

  // Register instance
  (function init() {
    $("[data-tw-toggle='collapse']").each(function () {
      $(this).closest(".accordion-header")[0]["__accordion"] =
        createInstance(this);
    });

    if (window.tailwind === undefined) window.tailwind = {};
    window.tailwind.Accordion = {
      getInstance(el) {
        return el.__accordion;
      },
      getOrCreateInstance(el) {
        return el.__accordion === undefined
          ? createInstance(el)
          : el.__accordion;
      },
    };
  })();
})();
