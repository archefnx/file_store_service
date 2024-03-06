import React from "react";
import { Routes, Route, Navigate } from 'react-router-dom';
import { publicRoutes } from "../routes";
import { FILE_ROUTE } from "../utils/consts";

const AppRouter = () => {
    return (
        <Routes>
            {publicRoutes.map(({ path, component: Component }) => 
                <Route key={path} path={path} element={<Component />} exact />
            )}

            <Route path="*" element={<Navigate to={FILE_ROUTE} />} />

        </Routes>
    );
};

export default AppRouter;
