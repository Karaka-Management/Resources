 # Info

 ## mpdf

 ### Dependencies

 * Psr\Log
 * setasign\Fpdi
 * DeepCopy

 ### Changes

 * Replaced `../data` path with `/data` path. The problem is that the data is outside of the namespace path which causes problems. In order to fix this the path was changed and the data directory was copied into the namespace directory.
 * Replaces `../ttfonts` path with `/ttfonts` path. Same reason as `data` path.
 * Replaces `../tmp` path with `/tmp` path. Same reason as `data` path.
