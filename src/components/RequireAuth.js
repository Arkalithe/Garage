import { useLocation, Navigate, Outlet } from "react-router-dom";
import useAuth from "../hooks/useAuth";

const RequireAuth = ({ allowedRoles }) => {
    const { auth } = useAuth();
    const location = useLocation();

    if (!auth.token) {
        return <Navigate to="/login" state={{ from: location }} replace />;
    }
    if (!allowedRoles.includes(auth.role)) {
        return <Navigate to="/unauthorized" state={{ from: location }} replace />;
    }
    return <Outlet />
}
export default RequireAuth;