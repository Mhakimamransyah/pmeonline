import InstallationHome from "./page/installation/InstallationHome";
import InstallationScoring from "./page/installation/InstallationScoring";
import InstallationStatistic from "./page/installation/InstallationStatistic";
import InstallationScoringEdit from "./page/installation/InstallationScoringEdit";

export default [
    {
        path: '/installation',
        component: InstallationHome,
    },
    {
        path: '/installation/scoring',
        component: InstallationScoring,
    },
    {
        path: '/installation/statistic',
        component: InstallationStatistic,
    },
    {
        path: '/installation/scoring/edit',
        component: InstallationScoringEdit,
        props: (route) => ({
            submit_id: route.query.submit_id,
        })
    },
]