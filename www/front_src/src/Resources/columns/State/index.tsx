import React from 'react';

import { Grid } from '@material-ui/core';

import { useCancelTokenSource } from '@centreon/ui';

import { ColumnProps } from '..';
import DowntimeDetailsTable from './DetailsTable/Downtime';
import AcknowledgementDetailsTable from './DetailsTable/Acknowledgement';
import { labelInDowntime, labelAcknowledged } from '../../translatedLabels';
import { Resource } from '../../models';
import HoverChip from '../HoverChip';
import DowntimeChip from '../../Chip/Downtime';
import AcknowledgeChip from '../../Chip/Acknowledge';
import { getData } from '../../api';

interface StateChipProps {
  endpoint: string;
  Chip: () => JSX.Element;
  DetailsTable: React.SFC<{ endpoint: string }>;
  label: string;
}

const StateHoverChip = ({
  endpoint,
  Chip,
  DetailsTable,
  label,
}: StateChipProps): JSX.Element => {
  const [loading, setLoading] = React.useState(true);
  const [data, setData] = React.useState();
  const { cancel, token } = useCancelTokenSource();

  React.useEffect(() => {
    getData({
      endpoint,
      requestParams: { cancelToken: token },
    })
      .then((retrievedData) => setData(retrievedData))
      .catch(() => setData(null))
      .finally(() => setLoading(false));

    return (): void => cancel();
  }, []);

  return (
    <HoverChip Chip={Chip} label={label}>
      <DetailsTable loading={loading} data={data} />
    </HoverChip>
  );
};

const DowntimeHoverChip = ({
  resource,
}: {
  resource: Resource;
}): JSX.Element => {
  return (
    <StateHoverChip
      endpoint={resource.downtime_endpoint as string}
      label={`${resource.name} ${labelInDowntime}`}
      DetailsTable={DowntimeDetailsTable}
      Chip={DowntimeChip}
    />
  );
};

const AcknowledgeHoverChip = ({
  resource,
}: {
  resource: Resource;
}): JSX.Element => {
  return (
    <StateHoverChip
      endpoint={resource.acknowledgement_endpoint as string}
      label={`${resource.name} ${labelAcknowledged}`}
      DetailsTable={AcknowledgementDetailsTable}
      Chip={AcknowledgeChip}
    />
  );
};

const StateColumn = ({ row }: ColumnProps): JSX.Element => {
  return (
    <Grid container spacing={1}>
      {row.in_downtime && (
        <Grid item>
          <DowntimeHoverChip resource={row} />
        </Grid>
      )}
      {row.acknowledged && (
        <Grid item>
          <AcknowledgeHoverChip resource={row} />
        </Grid>
      )}
    </Grid>
  );
};

export default StateColumn;
