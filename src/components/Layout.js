import { Outlet } from "react-router-dom";

const Layout = () => {

    return (
        <main className='d-flex flex-column m-auto'>
            <Outlet />
        </main>
    )
}

export default Layout;