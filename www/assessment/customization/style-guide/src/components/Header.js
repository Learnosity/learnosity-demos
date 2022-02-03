import React from "react";
import Box from "@mui/material/Box";
import { Typography } from "@mui/material";
import { colors } from "../mui-theme";

export default () => <Box className="header" sx={{
    display: 'flex',
    flexDirection: 'column',
    justifyContent: 'center',
    backgroundColor: colors.primaryBg,
    height: 162
}}>
    <Box sx={{
        mt: 3,
        ml: { xs: 2, sm: 16 },
        mr: { xs: 2, sm: 16 },
        mb: 3,
    }}>
        <Typography variant="h1" sx={{
            marginBottom: 2
        }}>Style Guide - selector identifier</Typography>
        <Typography variant="h4">Identify the class to style your assessment.</Typography>
    </Box>
</Box>;
