"use client";

import React, { useMemo } from "react";
import { ChevronRight } from "lucide-react";
import { hasPermission } from "@/assets/Auth/authUtils";
import { datosOpciones, type MenuItem, type MenuGroup } from "./DatosOpciones";
import { Link, useLocation, useNavigate } from "react-router-dom";

import {
  Collapsible,
  CollapsibleContent,
  CollapsibleTrigger,
} from "@/components/ui/collapsible";
import {
  SidebarGroup,
  SidebarGroupLabel,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  SidebarMenuSub,
  SidebarMenuSubButton,
  SidebarMenuSubItem,
} from "@/components/ui/sidebar";
import "./Menu.css";

const MenuItem = React.memo(({ item }: { item: MenuItem }) => {
  const navigate = useNavigate();
  const location = useLocation();
  const isActive = useMemo(() => {
    return (
      location.pathname === item.url ||
      item.items?.some((subItem) => location.pathname === subItem.url)
    );
  }, [location.pathname, item.url, item.items]);

  if (!hasPermission(item.permiso)) {
    return null;
  }

  const menuItemClasses = `group/collapsible
   ${item.clase || ""} ${isActive ? "active-menu" : ""}`;

  const handleClick = () => {
    if (!item.items && item.url) {
      navigate(item.url);
    }
  };

  return (
    <Collapsible
      key={item.title}
      asChild
      defaultOpen={isActive}
      className={menuItemClasses}
    >
      <SidebarMenuItem>
        <CollapsibleTrigger asChild>
          <SidebarMenuButton
            onClick={handleClick}
            className={`${menuItemClasses} cursor-pointer`}
            tooltip={item.title}
          >
            {item.icon && <item.icon />}
            <span>{item.title}</span>
            {item.items && (
              <ChevronRight className="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90" />
            )}
          </SidebarMenuButton>
        </CollapsibleTrigger>
        {item.items && (
          <CollapsibleContent>
            <SidebarMenuSub>
              {item.items.map((subItem) => {
                const isSubItemActive = location.pathname === subItem.url;
                const subItemClasses = `${subItem.clase || ""} ${
                  isSubItemActive ? "active" : ""
                }`;

                return (
                  hasPermission(subItem.permiso) && (
                    <SidebarMenuSubItem
                      key={subItem.title}
                      className={subItemClasses}
                    >
                      <SidebarMenuSubButton asChild>
                        <Link to={subItem.url}>
                          <span>{subItem.title}</span>
                        </Link>
                      </SidebarMenuSubButton>
                    </SidebarMenuSubItem>
                  )
                );
              })}
            </SidebarMenuSub>
          </CollapsibleContent>
        )}
      </SidebarMenuItem>
    </Collapsible>
  );
});

MenuItem.displayName = "MenuItem";

const MenuGroup = React.memo(({ group }: { group: MenuGroup }) => {
  const visibleItems = useMemo(() => {
    return Object.values(group.items).filter((item) =>
      hasPermission(item.permiso)
    );
  }, [group.items]);

  if (visibleItems.length === 0) {
    return null;
  }

  return (
    <SidebarGroup>
      <SidebarGroupLabel>{group.titulo}</SidebarGroupLabel>
      <SidebarMenu>
        {visibleItems.map((item) => (
          <MenuItem key={item.title} item={item} />
        ))}
      </SidebarMenu>
    </SidebarGroup>
  );
});

MenuGroup.displayName = "MenuGroup";

export const NavMain = React.memo(() => {
  const groups = useMemo(() => {
    return Object.values(datosOpciones);
  }, []);

  return (
    <>
      {groups.map((group) => (
        <MenuGroup key={group.titulo} group={group} />
      ))}
    </>
  );
});

NavMain.displayName = "NavMain";
