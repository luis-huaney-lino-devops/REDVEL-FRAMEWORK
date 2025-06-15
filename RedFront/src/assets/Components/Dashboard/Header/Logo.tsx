"use client";

import { GalleryVerticalEnd } from "lucide-react";

import {
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  // useSidebar,
} from "@/components/ui/sidebar";
import { useNavigate } from "react-router-dom";

export function LogoEmpresa() {
  // const { isMobile } = useSidebar();
  // const [activeTeam, setActiveTeam] = React.useState(teams[0]);

  // if (!activeTeam) {
  //   return null;
  // }

  const navigate = useNavigate();
  return (
    <SidebarMenu>
      <SidebarMenuItem>
        <SidebarMenuButton
          size="lg"
          onClick={() => navigate("/inicio")}
          className="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground cursor-pointer"
        >
          <div className="flex aspect-square size-8 items-center justify-center rounded-lg bg-sidebar-primary text-sidebar-primary-foreground">
            <GalleryVerticalEnd className="size-4" />
          </div>
          <div className="grid flex-1 text-left text-sm leading-tight">
            <span className="truncate font-semibold">{"TUTEC"}</span>
            <span className="truncate text-xs">{"premium"}</span>
          </div>
          {/* <ChevronsUpDown className="ml-auto" /> */}
        </SidebarMenuButton>
      </SidebarMenuItem>
    </SidebarMenu>
  );
}
