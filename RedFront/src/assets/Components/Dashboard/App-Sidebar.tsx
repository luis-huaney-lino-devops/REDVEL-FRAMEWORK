"use client";
import "./Sidebar.css";
import * as React from "react";
// import {
//   AudioWaveform,
//   BookOpen,
//   Bot,
//   Command,
//   Frame,
//   GalleryVerticalEnd,
//   Map,
//   PieChart,
//   Settings2,
//   SquareTerminal,
// } from "lucide-react";

import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarHeader,
  SidebarRail,
} from "@/components/ui/sidebar";
import { NavMain } from "./Opciones/NavMain";
import { LogoEmpresa } from "./Header/Logo";
import { NavUser } from "./Footer/Userfooter";

// This is sample data.

export function AppSidebar({ ...props }: React.ComponentProps<typeof Sidebar>) {
  return (
    <Sidebar collapsible="icon" {...props}>
      <SidebarHeader>
        {/* <TeamSwitcher teams={data.teams} /> */}
        <LogoEmpresa />
      </SidebarHeader>
      <SidebarContent className="contenedor-sidebar">
        <NavMain />
        {/* <NavProjects projects={data.projects} /> */}
      </SidebarContent>
      <SidebarFooter>
        {" "}
        <NavUser />
      </SidebarFooter>
      <SidebarRail />
    </Sidebar>
  );
}
