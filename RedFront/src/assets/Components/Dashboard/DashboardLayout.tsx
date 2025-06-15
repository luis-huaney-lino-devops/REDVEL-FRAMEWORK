import { Outlet } from "react-router-dom";
import { Toaster } from "react-hot-toast";
import { SidebarInset, SidebarProvider } from "@/components/ui/sidebar";
import { AppSidebar } from "./App-Sidebar";
import HeaderDashboard from "./Header/Header";

export default function DashboardLayout() {
  return (
    <SidebarProvider>
      <AppSidebar />
      <SidebarInset>
        <HeaderDashboard />
        <div className="flex-1 overflow-y-auto overflow-x-hidden">
          <div className="w-full max-w-7xl mx-auto py-6 ">
            <Outlet />
          </div>
        </div>
        <Toaster position="top-right" />
      </SidebarInset>
    </SidebarProvider>
  );
}
