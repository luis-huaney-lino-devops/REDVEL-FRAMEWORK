import { useEffect, useState } from "react";
import { Pencil, Trash2, Plus } from "lucide-react";

interface Empleado {
  id: number;
  nombre: string;
  dni: string;
  area: string;
  cargo: string;
  horario: string;
  estado: string;
}

const empleadosMock: Empleado[] = [
  {
    id: 1,
    nombre: "Ana López",
    dni: "45678912",
    area: "Contabilidad",
    cargo: "Analista",
    horario: "8:00 - 17:00",
    estado: "Activo",
  },
  {
    id: 2,
    nombre: "Pedro Rojas",
    dni: "33456789",
    area: "Logística",
    cargo: "Supervisor",
    horario: "Noche",
    estado: "Inactivo",
  },
  {
    id: 3,
    nombre: "Lucía Torres",
    dni: "42345678",
    area: "Recursos Humanos",
    cargo: "Asistente",
    horario: "8:00 - 16:00",
    estado: "Activo",
  },
];

export default function EmployeeManagement() {
  const [empleados] = useState<Empleado[]>(empleadosMock);
  useEffect(() => {
    const previousTitle = document.title;
    document.title = "GAAA";
    return () => {
      document.title = previousTitle;
    };
  }, []);
  return (
    <div className="space-y-6">
      <div className="flex justify-between items-center">
        <h2 className="text-2xl font-semibold">Gestión de Empleados</h2>
        <button className="bg-green-600 text-white px-4 py-2 rounded-xl hover:bg-green-700 flex items-center gap-2">
          <Plus className="w-4 h-4" /> Nuevo Empleado
        </button>
      </div>

      <div className="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
        <table className="min-w-full divide-y divide-gray-200">
          <thead className="bg-gray-100 text-left text-sm font-semibold text-gray-700">
            <tr>
              <th className="px-4 py-3">Nombre</th>
              <th className="px-4 py-3">DNI</th>
              <th className="px-4 py-3">Área</th>
              <th className="px-4 py-3">Cargo</th>
              <th className="px-4 py-3">Horario</th>
              <th className="px-4 py-3">Estado</th>
              <th className="px-4 py-3 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-gray-100 text-sm">
            {empleados.map((empleado) => (
              <tr key={empleado.id}>
                <td className="px-4 py-2">{empleado.nombre}</td>
                <td className="px-4 py-2">{empleado.dni}</td>
                <td className="px-4 py-2">{empleado.area}</td>
                <td className="px-4 py-2">{empleado.cargo}</td>
                <td className="px-4 py-2">{empleado.horario}</td>
                <td className="px-4 py-2">
                  <span
                    className={`px-2 py-1 rounded-full text-xs font-medium ${
                      empleado.estado === "Activo"
                        ? "bg-green-100 text-green-800"
                        : "bg-red-100 text-red-800"
                    }`}
                  >
                    {empleado.estado}
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
