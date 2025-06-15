import { Button } from "@/components/ui/button";
import { Card, CardContent, CardFooter } from "@/components/ui/card";
import { ArrowRight, Github, BookOpen, ArrowRightCircle } from "lucide-react";
import mysql from "./icons/mysql.svg";
import react from "./icons/react.svg";
import react_w from "./icons/react-white.svg";
import laravel from "./icons/laravel.svg";
import laravel_w from "./icons/laravel-white.svg";
import react_router from "./icons/react-router.svg";
import query from "./icons/query.svg";
import axios from "./icons/axios.svg";
import redvel from "./icons/Redvel.svg";

import "./Redvel.css";
import { ThemeToggle } from "@/assets/Components/Generalidades/Theme-toogle";
import { useNavigate } from "react-router-dom";

export default function Redvel() {
  const navigate = useNavigate();
  return (
    <section className="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800 flex items-center justify-center">
      <div className="container max-w-7xl mx-auto">
        <Card className="overflow-hidden shadow-2xl border-0 bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm">
          <CardContent className="p-0">
            <div className=" absolute top-0 left-0">
              {" "}
              <ThemeToggle />
            </div>
            <div className="grid lg:grid-cols-2 gap-0 min-h-[450px]">
              {/* Left Content */}
              <div className="flex flex-col justify-center p-4 lg:p-8 space-y-4">
                <div className="space-y-4">
                  <div className="space-y-3">
                    <div className="inline-flex items-center gap-2 px-3 py-1 bg-red-50 dark:bg-red-950/50 rounded-full border border-red-100 dark:border-red-800">
                      {/* <Zap className="w-3 h-3 text-red-600 dark:text-red-400" /> */}
                      <span className="text-xs font-medium text-red-700 dark:text-red-300">
                        Desarrollado por TUTEC
                      </span>
                    </div>

                    <h1 className="text-3xl lg:text-5xl tracking-tight animate-slide-in-left">
                      <span className="titulo bg-gradient-to-r bg-clip-text text-transparent dark:from-red-400 dark:to-red-600">
                        Redvel
                      </span>
                    </h1>

                    <p className="text-lg lg:text-xl text-slate-600 dark:text-slate-300 font-light leading-relaxed animate-slide-in-left animation-delay-200">
                      El framework que combina la potencia de{" "}
                      <span className="font-semibold text-blue-600 dark:text-blue-400">
                        React
                      </span>{" "}
                      con la elegancia de{" "}
                      <span className="font-semibold text-red-500 dark:text-red-400">
                        Laravel
                      </span>
                    </p>
                  </div>

                  <p className="text-base text-slate-500 dark:text-slate-400 leading-relaxed animate-fade-in animation-delay-300">
                    Desarrolla aplicaciones web modernas con la mejor
                    experiencia de desarrollador.
                  </p>

                  <div className="flex flex-col sm:flex-row gap-3 animate-slide-in-up animation-delay-400">
                    <Button
                      onClick={() => {
                        navigate("/login");
                      }}
                      size="default"
                      className="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 cursor-pointer text-white px-6 py-2"
                    >
                      Comenzar Ahora
                      <ArrowRight className="ml-2 w-4 h-4" />
                    </Button>
                    <Button
                      variant="outline"
                      size="default"
                      className="border-slate-300 dark:border-slate-600 dark:bg-slate-800/50 dark:text-slate-200 dark:hover:bg-slate-700 cursor-pointer px-6 py-2"
                    >
                      <Github className="mr-2 w-4 h-4" />
                      Ver en GitHub
                    </Button>
                  </div>
                </div>
              </div>

              {/* Right Visual */}
              <div className="relative bg-gradient-to-br from-red-500 to-red-700 dark:from-red-600 dark:to-red-800 flex items-center justify-center p-2 lg:p-4">
                <div className="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4gPGcgZmlsbD0ibm9uZSIgZmlsbFJ1bGU9ImV2ZW5vZGQiPiA8ZyBmaWxsPSIjZmZmZmZmIiBmaWxsT3BhY2l0eT0iMC4xIj4gPGNpcmNsZSBjeD0iMzAiIGN5PSIzMCIgcj0iMiIvPiA8L2c+IDwvZz4gPC9zdmc+')] opacity-20 dark:opacity-30"></div>

                <div className="relative z-10 text-center space-y-4">
                  <div className="w-20 h-20 lg:w-24 lg:h-24 mx-auto bg-white/20 dark:bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center border border-white/30 dark:border-white/20 animate-bounce-in animation-delay-200">
                    <img src={redvel} alt="Redvel" className="" />
                    {/* <div className="text-4xl lg:text-5xl font-bold text-white">
                      R
                    </div> */}
                  </div>

                  <div className="space-y-2 animate-fade-in animation-delay-400">
                    <h2 className="text-xl lg:text-2xl font-bold text-white">
                      React + Laravel
                    </h2>
                    <p className="text-red-100 dark:text-red-200 text-sm lg:text-base max-w-xs mx-auto">
                      La combinación perfecta para aplicaciones modernas
                    </p>
                  </div>

                  <div className="flex justify-center gap-3 animate-slide-in-up animation-delay-600">
                    <div className="w-12 h-12 bg-white/20 dark:bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30 dark:border-white/20">
                      <img src={react_w} alt="" className="w-6 h-6" />
                    </div>
                    <div className="w-12 h-12 bg-white/20 dark:bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30 dark:border-white/20">
                      <img src={laravel_w} alt="" className="w-6 h-6" />
                    </div>
                  </div>

                  <Button
                    variant="secondary"
                    size="sm"
                    className="bg-white dark:bg-slate-800 cursor-pointer text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-slate-700 animate-fade-in animation-delay-700"
                  >
                    <BookOpen className="mr-2 w-4 h-4" />
                    Documentación
                  </Button>
                </div>
              </div>
            </div>
          </CardContent>

          <CardFooter className="px-4 lg:px-8 py-4 dark:bg-slate-900/50">
            <div className="w-full">
              <h3 className="text-base lg:text-lg font-semibold mb-4 text-slate-700 dark:text-slate-200 text-center animate-fade-in animation-delay-800">
                Arquitectura Redvel
              </h3>

              <div className="flex justify-center">
                <div className="relative overflow-x-auto pb-2">
                  <div className="flex flex-nowrap items-center justify-center gap-1 lg:gap-3 px-2">
                    {/* Database */}
                    <div className="flex flex-col items-center gap-1 w-16 lg:w-20 animate-slide-in-up animation-delay-1000">
                      <div className="w-10 h-10 lg:w-12 lg:h-12 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center transform hover:scale-110 transition-transform duration-300">
                        <img
                          className="w-5 h-5 lg:w-6 lg:h-6"
                          src={mysql}
                          alt="MySQL"
                        />
                      </div>
                      <div className="text-center">
                        <p className="font-medium text-slate-800 dark:text-slate-200 text-xs lg:text-sm">
                          Database
                        </p>
                        <p className="text-xs text-slate-500 dark:text-slate-400 hidden lg:block">
                          MySQL, PostgreSQL
                        </p>
                      </div>
                    </div>

                    {/* Arrow 1 */}
                    <ArrowRightCircle className="w-3 h-3 lg:w-4 lg:h-4 text-slate-400 dark:text-slate-500 animate-pulse animation-delay-1200" />

                    {/* Laravel */}
                    <div className="flex flex-col items-center gap-1 w-16 lg:w-20 animate-slide-in-up animation-delay-1100">
                      <div className="w-10 h-10 lg:w-12 lg:h-12 bg-red-100 dark:bg-red-900/50 rounded-lg flex items-center justify-center transform hover:scale-110 transition-transform duration-300">
                        <img
                          className="w-5 h-5 lg:w-6 lg:h-6"
                          src={laravel}
                          alt="Laravel"
                        />
                      </div>
                      <div className="text-center">
                        <p className="font-medium text-slate-800 dark:text-slate-200 text-xs lg:text-sm">
                          Laravel
                        </p>
                        <p className="text-xs text-slate-500 dark:text-slate-400 hidden lg:block">
                          Backend API
                        </p>
                      </div>
                    </div>

                    {/* Arrow 2 */}
                    <ArrowRightCircle className="w-3 h-3 lg:w-4 lg:h-4 text-slate-400 dark:text-slate-500 animate-pulse animation-delay-1300" />

                    {/* Axios */}
                    <div className="flex flex-col items-center gap-1 w-16 lg:w-20 animate-slide-in-up animation-delay-1200">
                      <div className="w-20 h-10 lg:w-20 lg:h-12 bg-purple-100 dark:bg-gray-400 rounded-lg flex items-center justify-center transform hover:scale-110 transition-transform duration-300">
                        <img className="w-15" src={axios} alt="Axios" />
                      </div>
                      <div className="text-center">
                        <p className="font-medium text-slate-800 dark:text-slate-200 text-xs lg:text-sm">
                          Axios
                        </p>
                        <p className="text-xs text-slate-500 dark:text-slate-400 hidden lg:block">
                          HTTP Client
                        </p>
                      </div>
                    </div>

                    {/* Arrow 3 */}
                    <ArrowRightCircle className="w-3 h-3 lg:w-4 lg:h-4 text-slate-400 dark:text-slate-500 animate-pulse animation-delay-1400" />

                    {/* TanStack Query */}
                    <div className="flex flex-col items-center gap-1 w-16 lg:w-20 animate-slide-in-up animation-delay-1300">
                      <div className="w-10 h-10 lg:w-12 lg:h-12 bg-amber-100 dark:bg-amber-900/50 rounded-lg flex items-center justify-center transform hover:scale-110 transition-transform duration-300">
                        <img
                          className="w-5 h-5 lg:w-6 lg:h-6"
                          src={query}
                          alt="TanStack Query"
                        />
                      </div>
                      <div className="text-center">
                        <p className="font-medium text-slate-800 dark:text-slate-200 text-xs lg:text-sm">
                          TanStack
                        </p>
                        <p className="text-xs text-slate-500 dark:text-slate-400 hidden lg:block">
                          Data Fetching
                        </p>
                      </div>
                    </div>

                    {/* Arrow 4 */}
                    <ArrowRightCircle className="w-3 h-3 lg:w-4 lg:h-4 text-slate-400 dark:text-slate-500 animate-pulse animation-delay-1500" />

                    {/* React + Router */}
                    <div className="flex flex-col items-center gap-1 w-16 lg:w-20 animate-slide-in-up animation-delay-1400">
                      <div className="w-20 h-12 lg:w-20 lg:h-12 bg-gray-100 dark:bg-gray-800/50 rounded-lg flex items-center justify-center transform hover:scale-110 transition-transform duration-300">
                        <div className="flex items-center gap-0.5">
                          <img
                            className="w-6 h-6 lg:w-8 lg:h-8"
                            src={react}
                            alt="React"
                          />
                          <img
                            className="w-6 h-6 lg:w-8 lg:h-8"
                            src={react_router}
                            alt="React Router"
                          />
                        </div>
                      </div>
                      <div className="text-center">
                        <p className="font-medium text-slate-800 dark:text-slate-200 text-xs lg:text-sm">
                          React
                        </p>
                        <p className="text-xs text-slate-500 dark:text-slate-400 hidden lg:block">
                          UI & Router
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </CardFooter>
        </Card>
      </div>
    </section>
  );
}
