import { Outlet } from "react-router-dom";

const Layout = () => {

    return (
        <main className='d-flex flex-column align-items-center justify-content-start'>
            <Outlet />
        </main>
    )
}

export default Layout;