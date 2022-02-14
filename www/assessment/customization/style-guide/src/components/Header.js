import React from "react";
import Box from "@mui/material/Box";
import Typography from "@mui/material/Typography";
import { colors } from "../mui-theme";


export default () => <Box className="header" sx={{
    display: 'flex',
    flexDirection: 'column',
    justifyContent: 'center',
    backgroundColor: colors.primaryBg
}}>
    <Box sx={{
        mt: 3,
        ml: { xs: 2, sm: 16 },
        mr: { xs: 2, sm: 16 },
        mb: 3,
    }}>
        <Box sx={{ width: {
                md: 240,
                sm: 200,
                xs: 220
        }, mb: 2 }}>
            <img src="public/learnosity-logo.png" alt="Learnosity logo" width="100%" />
        </Box>
        <Typography variant="h1" sx={{
            marginBottom: 2
        }}>BETA selector identifier</Typography>
        <Box sx={{ width: { md: 600, sm: '100%' } }} >
            <Typography variant="h4">Use our new tool to identify the selectors needed to style your assessment. This tool aims to provide clarity on what classes to use for future iterations. Please feel free to provide us with any feedback using the feedback button below.</Typography>
        </Box>
    </Box>
</Box>;
