import './styles/App.css';
import { Outlet } from 'react-router-dom';
import Navbar from './components/Navbar';
import React, { Suspense } from 'react';
import Loading from './components/load';
import { ImovelProvider } from './contexts/ImovelContext';

function App() {
  return (
    <div className="App">
      <ImovelProvider>
        <Navbar id="navbar" />
        <Suspense fallback={<Loading mensagem="Carregando página..." />}>
          <Outlet />
        </Suspense>
      </ImovelProvider>
    </div>
  );
}

export default App;
