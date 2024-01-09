import type { Survey } from "@/types/Survey";
import type { User } from "@/types/User";

export type UserState = {
    user: {
        data: User;
        token: string | null;
    };
};

export type CurrentSurveyState = {
    currentSurvey: {
        loading: boolean;
        data: Survey;
    }
};

export type SurveyState = {
    surveys: {
        loading: boolean;
        data: Survey[];
    };
};