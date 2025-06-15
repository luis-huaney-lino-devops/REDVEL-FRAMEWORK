import { useState } from "react";
import { Pencil, Trash2, Plus } from "lucide-react";

interface Usuario {
  id: number;
  nombre: string;
  correo: string;
  rol: string;
  estado: string;
}

const usuariosEjemplo: Usuario[] = [
  {
    id: 1,
    nombre: "Juan Pérez",
    correo: "juan@correo.com",
    rol: "Administrador",
    estado: "Activo",
  },
  {
    id: 2,
    nombre: "María Gómez",
    correo: "maria@correo.com",
    rol: "Supervisor",
    estado: "Inactivo",
  },
  {
    id: 3,
    nombre: "Carlos Ríos",
    correo: "carlos@correo.com",
    rol: "Empleado",
    estado: "Activo",
  },
];

export default function PageUsuarios() {
  const [usuarios] = useState<Usuario[]>(usuariosEjemplo);

  return (
    <div className="space-y-6">
      <div className="flex justify-between items-center">
        <h2 className="text-2xl font-semibold">Gestión de Usuarios</h2>
        <button className="bg-blue-600 text-white px-4 py-2 rounded-xl hover:bg-blue-700 flex items-center gap-2">
          <Plus className="w-4 h-4" /> Agregar Usuario
        </button>
      </div>

      <div className="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
        <table className="min-w-full divide-y divide-gray-200">
          <thead className="bg-gray-100 text-left text-sm font-semibold text-gray-700">
            <tr>
              <th className="px-4 py-3">Nombre</th>
              <th className="px-4 py-3">Correo</th>
              <th className="px-4 py-3">Rol</th>
              <th className="px-4 py-3">Estado</th>
              <th className="px-4 py-3 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-gray-100 text-sm">
            {usuarios.map((usuario) => (
              <tr key={usuario.id}>
                <td className="px-4 py-2">{usuario.nombre}</td>
                <td className="px-4 py-2">{usuario.correo}</td>
                <td className="px-4 py-2">{usuario.rol}</td>
                <td className="px-4 py-2">
                  <span
                    className={`px-2 py-1 rounded-full text-xs font-medium ${
                      usuario.estado === "Activo"
                        ? "bg-green-100 text-green-800"
                        : "bg-red-100 text-red-800"
                    }`}
                  >
                    {usuario.estado}
                  </span>
                </td>
                <td className="px-4 py-2 text-center space-x-2">
                  <button className="text-blue-600 hover:text-blue-800">
                    <Pencil className="w-4 h-4" />
                  </button>
                  <button className="text-red-600 hover:text-red-800">
                    <Trash2 className="w-4 h-4" />
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}
