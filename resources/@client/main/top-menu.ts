import { type Menu } from "@/stores/menu";

const menu: Array<Menu | "divider"> = [
  {
    icon: "Home",
    pageName: "home",
    title: "Dashboard"
  },
  {
    icon: "Layers",
    pageName: "layout",
    title: "Realms",
    subMenu: [
      {
        icon: "Activity",
        pageName: "wizards",
        title: "Realms",
        subMenu: [
          {
            icon: "Zap",
            pageName: "wizard-layout-1",
            title: "The Kingdom of Burning Lands",
          },
          {
            icon: "Zap",
            pageName: "wizard-layout-2",
            title: "The Celestial Kingdom",
          },
          {
            icon: "Zap",
            pageName: "wizard-layout-3",
            title: "The Kingdom of Northern Lights",
          },
        ],
      },
      {
        icon: "Activity",
        pageName: "blog",
        title: "Principalities",
        subMenu: [
          {
            icon: "Zap",
            pageName: "blog-layout-1",
            title: "Principality 1",
          },
          {
            icon: "Zap",
            pageName: "blog-layout-2",
            title: "Principality 2",
          },
          {
            icon: "Zap",
            pageName: "blog-layout-3",
            title: "Principality 3",
          },
        ],
      },
      {
        icon: "Activity",
        pageName: "pricing",
        title: "Grand Dutchies",
        subMenu: [
          {
            icon: "Zap",
            pageName: "pricing-layout-1",
            title: "Midgard",
          },
          {
            icon: "Zap",
            pageName: "pricing-layout-2",
            title: "GD 2",
          },
        ],
      },
    ],
  },
  {
    icon: "User",
    pageName: "profile",
    title: "Persona",
  },
  {
    icon: "Inbox",
    pageName: "components",
    title: "Events",
    subMenu: [
      {
        icon: "Activity",
        pageName: "table",
        title: "Coming Up",
        subMenu: [
          {
            icon: "Zap",
            pageName: "modal",
            title: "NLCC Fall",
          },
          {
            icon: "Zap",
            pageName: "slide-over",
            title: "Keep on the Boarderlands",
          },
        ],
      },
      {
        icon: "Activity",
        pageName: "overlay",
        title: "Recently Past",
        subMenu: [
          {
            icon: "Zap",
            pageName: "modal",
            title: "SKBC",
          },
          {
            icon: "Zap",
            pageName: "slide-over",
            title: "Spring War",
          },
        ],
      },
    ],
  },
];

export default menu;
