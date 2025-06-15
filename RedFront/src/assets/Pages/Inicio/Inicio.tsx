import { useEffect } from "react";
import {
  AreaChart,
  Area,
  XAxis,
  YAxis,
  CartesianGrid,
  Tooltip,
  ResponsiveContainer,
  PieChart,
  Pie,
  Cell,
} from "recharts";
import {
  Users,
  Droplet,
  AlertTriangle,
  Clock,
  TrendingUp,
  TrendingDown,
} from "lucide-react";

// Datos de ejemplo para los gráficos
const consumoMensual = [
  { mes: "Ene", consumo: 4000, costo: 2400 },
  { mes: "Feb", consumo: 3000, costo: 1398 },
  { mes: "Mar", consumo: 2000, costo: 9800 },
  { mes: "Abr", consumo: 2780, costo: 3908 },
  { mes: "May", consumo: 1890, costo: 4800 },
  { mes: "Jun", consumo: 2390, costo: 3800 },
];

const distribucionConsumo = [
  { name: "Residencial", value: 45 },
  { name: "Comercial", value: 30 },
  { name: "Industrial", value: 15 },
  { name: "Otros", value: 10 },
];

const COLORS = ["#0088FE", "#00C49F", "#FFBB28", "#FF8042"];

const alertas = [
  { id: 1, tipo: "Fuga", ubicacion: "Sector Norte", prioridad: "Alta" },
  { id: 2, tipo: "Presión Baja", ubicacion: "Sector Sur", prioridad: "Media" },
  { id: 3, tipo: "Contaminación", ubicacion: "Sector Este", prioridad: "Alta" },
];

export default function Dashboar_Stats() {
  useEffect(() => {
    const previousTitle = document.title;
    document.title = "Dashboard";
    return () => {
      document.title = previousTitle;
    };
  }, []);

  return (
    <div className="space-y-6 p-6">
      {/* Tarjetas de Resumen */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div className="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
          <div className="flex items-center justify-between">
            <div>
              <p className="text-sm text-gray-500">Consumo Total</p>
              <h3 className="text-2xl font-bold text-gray-800">16,240 m³</h3>
              <p className="text-sm text-green-600 flex items-center mt-2">
                <TrendingUp className="w-4 h-4 mr-1" />
                +12.5% vs mes anterior
              </p>
            </div>
            <div className="bg-blue-100 p-3 rounded-full">
              <Droplet className="w-6 h-6 text-blue-600" />
            </div>
          </div>
        </div>

        <div className="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
          <div className="flex items-center justify-between">
            <div>
              <p className="text-sm text-gray-500">Usuarios Activos</p>
              <h3 className="text-2xl font-bold text-gray-800">2,543</h3>
              <p className="text-sm text-green-600 flex items-center mt-2">
                <TrendingUp className="w-4 h-4 mr-1" />
                +5.2% vs mes anterior
              </p>
            </div>
            <div className="bg-green-100 p-3 rounded-full">
              <Users className="w-6 h-6 text-green-600" />
            </div>
          </div>
        </div>

        <div className="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
          <div className="flex items-center justify-between">
            <div>
              <p className="text-sm text-gray-500">Alertas Activas</p>
              <h3 className="text-2xl font-bold text-gray-800">12</h3>
              <p className="text-sm text-red-600 flex items-center mt-2">
                <TrendingDown className="w-4 h-4 mr-1" />
                -3.1% vs mes anterior
              </p>
            </div>
            <div className="bg-red-100 p-3 rounded-full">
              <AlertTriangle className="w-6 h-6 text-red-600" />
            </div>
          </div>
        </div>

        <div className="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
          <div className="flex items-center justify-between">
            <div>
              <p className="text-sm text-gray-500">Tiempo Promedio</p>
              <h3 className="text-2xl font-bold text-gray-800">2.4h</h3>
              <p className="text-sm text-green-600 flex items-center mt-2">
                <TrendingUp className="w-4 h-4 mr-1" />
                +8.3% vs mes anterior
              </p>
            </div>
            <div className="bg-purple-100 p-3 rounded-full">
              <Clock className="w-6 h-6 text-purple-600" />
            </div>
          </div>
        </div>
      </div>

      {/* Gráficos */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {/* Gráfico de Consumo */}
        <div className="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
          <h3 className="text-lg font-semibold text-gray-800 mb-4">
            Consumo Mensual
          </h3>
          <div className="h-[300px]">
            <ResponsiveContainer width="100%" height="100%">
              <AreaChart data={consumoMensual}>
                <CartesianGrid strokeDasharray="3 3" />
                <XAxis dataKey="mes" />
                <YAxis />
                <Tooltip />
                <Area
                  type="monotone"
                  dataKey="consumo"
                  stroke="#3B82F6"
                  fill="#93C5FD"
                  fillOpacity={0.3}
                />
              </AreaChart>
            </ResponsiveContainer>
          </div>
        </div>

        {/* Gráfico de Distribución */}
        <div className="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
          <h3 className="text-lg font-semibold text-gray-800 mb-4">
            Distribución de Consumo
          </h3>
          <div className="h-[300px]">
            <ResponsiveContainer width="100%" height="100%">
              <PieChart>
                <Pie
                  data={distribucionConsumo}
                  cx="50%"
                  cy="50%"
                  labelLine={false}
                  outerRadius={80}
                  fill="#8884d8"
                  dataKey="value"
                  label={({ name, percent }) =>
                    `${name} ${(percent * 100).toFixed(0)}%`
                  }
                >
                  {distribucionConsumo.map((entry, index) => (
                    <Cell
                      key={`cell-${index}`}
                      fill={COLORS[index % COLORS.length]}
                    />
                  ))}
                </Pie>
                <Tooltip />
              </PieChart>
            </ResponsiveContainer>
          </div>
        </div>
      </div>

      {/* Tabla de Alertas */}
      <div className="bg-white rounded-xl shadow-sm border border-gray-100">
        <div className="p-6 border-b border-gray-100">
          <h3 className="text-lg font-semibold text-gray-800">
            Alertas Recientes
          </h3>
        </div>
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead className="bg-gray-50">
              <tr>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Tipo
                </th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Ubicación
                </th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Prioridad
                </th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Estado
                </th>
              </tr>
            </thead>
            <tbody className="bg-white divide-y divide-gray-100">
              {alertas.map((alerta) => (
                <tr key={alerta.id}>
                  <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    {alerta.tipo}
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {alerta.ubicacion}
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    <span
                      className={`px-2 py-1 text-xs font-medium rounded-full ${
                        alerta.prioridad === "Alta"
                          ? "bg-red-100 text-red-800"
                          : "bg-yellow-100 text-yellow-800"
                      }`}
                    >
                      {alerta.prioridad}
                    </span>
                  </td>
                  <td className="px-6 py-4 whitespace-nowrap">
                    <span className="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                      En Proceso
                    </span>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}
