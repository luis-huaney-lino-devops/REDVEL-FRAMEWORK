"use client";

import * as XLSX from "xlsx";
import { jsPDF } from "jspdf";
import autoTable from "jspdf-autotable";
import { format } from "date-fns";
import { es } from "date-fns/locale";
import type { ExportFormat } from "./type/generic-table";

export interface ExportColumn {
  key: string;
  label: string;
}

/**
 * Convierte un valor de celda a string/número exportable (sin HTML ni componentes).
 */
function cellToExportValue(value: unknown): string | number {
  if (value === null || value === undefined) return "";
  if (typeof value === "number" && !Number.isNaN(value)) return value;
  if (typeof value === "boolean") return value ? "Sí" : "No";
  if (value instanceof Date) return format(value, "dd/MM/yyyy HH:mm", { locale: es });
  if (typeof value === "object" && "toString" in value) return String(value);
  return String(value);
}

/**
 * Construye filas para exportar: array de objetos { [label]: value } por columna exportable.
 */
function buildExportRows(
  data: Record<string, unknown>[],
  columns: ExportColumn[]
): Record<string, string | number>[] {
  return data.map((row) => {
    const out: Record<string, string | number> = {};
    for (const col of columns) {
      const raw = row[col.key];
      out[col.label] = cellToExportValue(raw);
    }
    return out;
  });
}

function escapeXml(str: string): string {
  return str
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&apos;");
}

export function exportToJson(
  data: Record<string, unknown>[],
  columns: ExportColumn[],
  filenameBase: string
): void {
  const rows = buildExportRows(data, columns);
  const blob = new Blob([JSON.stringify(rows, null, 2)], {
    type: "application/json;charset=utf-8",
  });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = `${filenameBase}.json`;
  a.click();
  URL.revokeObjectURL(url);
}

export function exportToXml(
  data: Record<string, unknown>[],
  columns: ExportColumn[],
  filenameBase: string
): void {
  const rows = buildExportRows(data, columns);
  let xml = '<?xml version="1.0" encoding="UTF-8"?>\n<data>\n';
  for (const row of rows) {
    xml += "  <row>\n";
    for (const [label, value] of Object.entries(row)) {
      const tag = label.replace(/[^a-zA-Z0-9_]/g, "_");
      xml += `    <${tag}>${escapeXml(String(value))}</${tag}>\n`;
    }
    xml += "  </row>\n";
  }
  xml += "</data>";
  const blob = new Blob([xml], { type: "application/xml;charset=utf-8" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = `${filenameBase}.xml`;
  a.click();
  URL.revokeObjectURL(url);
}

export function exportToCsv(
  data: Record<string, unknown>[],
  columns: ExportColumn[],
  filenameBase: string
): void {
  const rows = buildExportRows(data, columns);
  const headers = columns.map((c) => c.label);
  const lines = [headers.map((h) => `"${String(h).replace(/"/g, '""')}"`).join(",")];
  for (const row of rows) {
    const values = headers.map((h) => {
      const v = row[h];
      return `"${String(v).replace(/"/g, '""')}"`;
    });
    lines.push(values.join(","));
  }
  const csv = lines.join("\n");
  const blob = new Blob(["\ufeff" + csv], { type: "text/csv;charset=utf-8" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = `${filenameBase}.csv`;
  a.click();
  URL.revokeObjectURL(url);
}

export function exportToTxt(
  data: Record<string, unknown>[],
  columns: ExportColumn[],
  filenameBase: string
): void {
  const rows = buildExportRows(data, columns);
  const headers = columns.map((c) => c.label);
  const colWidth = 20;
  const pad = (s: string) => s.slice(0, colWidth).padEnd(colWidth);
  const lines = [headers.map((h) => pad(String(h))).join(" ")];
  lines.push("-".repeat(headers.length * (colWidth + 1)));
  for (const row of rows) {
    lines.push(headers.map((h) => pad(String(row[h]))).join(" "));
  }
  const txt = lines.join("\n");
  const blob = new Blob([txt], { type: "text/plain;charset=utf-8" });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = `${filenameBase}.txt`;
  a.click();
  URL.revokeObjectURL(url);
}

export function exportToExcel(
  data: Record<string, unknown>[],
  columns: ExportColumn[],
  filenameBase: string
): void {
  const rows = buildExportRows(data, columns);
  const ws = XLSX.utils.json_to_sheet(rows);
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "Datos");
  XLSX.writeFile(wb, `${filenameBase}.xlsx`);
}

export function exportToPdf(
  data: Record<string, unknown>[],
  columns: ExportColumn[],
  filenameBase: string
): void {
  const rows = buildExportRows(data, columns);
  const head = [columns.map((c) => c.label)];
  const body = rows.map((row) => columns.map((c) => String(row[c.label] ?? "")));
  const doc = new jsPDF({ orientation: "landscape", unit: "mm" });
  autoTable(doc, {
    head,
    body,
    styles: { fontSize: 8 },
    headStyles: { fillColor: [59, 130, 246] },
    margin: { top: 10 },
  });
  doc.save(`${filenameBase}.pdf`);
}

const EXPORTERS: Record<
  ExportFormat,
  (data: Record<string, unknown>[], cols: ExportColumn[], name: string) => void
> = {
  json: exportToJson,
  xml: exportToXml,
  csv: exportToCsv,
  txt: exportToTxt,
  msexcel: exportToExcel,
  pdf: exportToPdf,
};

export function runExport(
  format: ExportFormat,
  data: Record<string, unknown>[],
  columns: ExportColumn[],
  filenameBase: string = "export"
): void {
  const fn = EXPORTERS[format];
  if (fn) fn(data, columns, filenameBase);
}

export const EXPORT_FORMAT_LABELS: Record<ExportFormat, string> = {
  json: "JSON",
  xml: "XML",
  csv: "CSV",
  txt: "TXT",
  msexcel: "MS Excel",
  pdf: "PDF",
};
