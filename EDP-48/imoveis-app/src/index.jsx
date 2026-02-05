import React, { lazy } from 'react';
import ReactDOM from 'react-dom/client';
import reportWebVitals from './reportWebVitals';
import './styles/index.css';
import { createBrowserRouter, RouterProvider } from 'react-router-dom';
import Cadastro from './components/CadastroDeImovel';
import Edicao from './components/EdicaoDeImovel';
import Reajuste from './components/ReajusteDePrecoEmMassa';
import Exportacao from './components/ExportacaoDeImoveis';

import ErrorPage from './routes/ErrorPage';

import App from './App';
import ModalFiltro from './components/ModalFiltro';

const Imovel = lazy(() => import('./routes/Imovel'));
const Home = lazy(() => import('./routes/Home'));

const router = createBrowserRouter([
  {
    path: '/',
    element: <App />,
    // pagina de erro
    errorElement: <ErrorPage />,

    children: [
      {
        path: '/',
        element: <Home />,
      },
      {
        path: 'imovel',
        element: <Imovel />,
      },
      {
        path: 'imovel/cadastro',
        element: <Cadastro />,

      },
      {
        path: 'imovel/edicao/:id',
        element: <Edicao />,
      },
      {
        path: 'imovel/reajuste/:id',
        element: <Reajuste />,
      },
      {
        path: 'imovel/exportacao/:id',
        element: <Exportacao />,
      },
      {
        path:'imovel/filtro',
        element:<ModalFiltro/>
      },
    ]
  },

]);

const root =

ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <RouterProvider router={router} />
  </React.StrictMode>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
